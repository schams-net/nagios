<?php
declare(strict_types = 1);
namespace SchamsNet\Nagios\Controller;

/*
 * This file is part of the TYPO3 CMS Extension "Nagios TYPO3 Monitoring"
 *
 * Author: Michael Schams <schams.net>
 * Website: https://schams.net
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use SchamsNet\Nagios\Utility\AccessUtility;

use SchamsNet\Nagios\Details\ServerDetails;
use SchamsNet\Nagios\Details\Typo3Details;
use SchamsNet\Nagios\Details\ConfigurationDetails;
use SchamsNet\Nagios\Details\ExtensionDetails;

/**
 * Main controller
 */
class NagiosController
{
    /**
     * Constants used as keywords in output
     */
    private const KEY_PHP = 'PHP';
    private const KEY_TYPO3 = 'TYPO3';
    private const KEY_EXTENSION = 'EXT';
    private const KEY_SITENAME = 'SITENAME';
    private const KEY_SERVERNAME = 'SERVERNAME';
    private const KEY_APPLICATION_CONTEXT = 'APPLICATIONCONTEXT';
    private const KEY_TIMESTAMP = 'TIMESTAMP';
    private const KEY_MESSAGE = 'MESSAGE';
    public const KEY_VERSION = 'version';

    /**
     * Extension key
     *
     * @access private
     * @var string
     */
    private $extensionKey = 'nagios';

    /**
     * Extension configuration
     *
     * @access private
     * @var ExtensionConfiguration
     */
    private $extensionConfiguration = null;

    /**
     * Object Manager
     *
     * @access private
     * @var ObjectManager
     */
    private $objectManager = null;

    /**
     * Server details
     *
     * @access private
     * @var ServerDetails
     */
    private $server = null;

    /**
     * TYPO3 instance details
     *
     * @access private
     * @var Typo3Details
     */
    private $typo3instance = null;

    /**
     * Extension details
     *
     * @access private
     * @var ExtensionDetails
     */
    private $extensions = null;

    /**
     * Configuration details
     *
     * @access private
     * @var ConfigurationDetails
     */
    private $configuration = null;

    /**
     * Default constructor
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        // Extension configuration
        $this->extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);

        /** @var $objectManager ObjectManager */
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var $server ServerDetails */
        $this->server = $this->objectManager->get(ServerDetails::class);

        /** @var $typo3instance Typo3Details */
        $this->typo3instance = $this->objectManager->get(Typo3Details::class);

        /** @var $extensions ExtensionDetails */
        $this->extensions = $this->objectManager->get(ExtensionDetails::class);

        /** @var $configuration ConfigurationDetails */
        $this->configuration = $this->objectManager->get(ConfigurationDetails::class);
    }

    /**
     * Dispatcher method
     *
     * @access public
     * @param ServerRequestInterface $request PSR-7 server request interface
     * @return Response
     */
    public function execute(ServerRequestInterface $request): Response
    {
        $data = [];

        // Send header if not configured as suppressed
        if ($this->extensionConfiguration->get($this->extensionKey, 'securitySupressHeader') != 1) {
            $version = $this->extensions->getExtensionVersion($this->extensionKey);
            $header = '# Nagios TYPO3 Monitoring Version ' . $version . ' - https://schams.net/nagios';
        }

        // Check if client is allowed to access details of this TYPO3 instance
        $isValidClient = AccessUtility::isValidClient(
            $this->extensionConfiguration->get($this->extensionKey, 'securityNagiosServerList'),
            $this->extensionConfiguration->get($this->extensionKey, 'securityProxyHeaders'),
            $request
        );

        if ($isValidClient === true) {
            // Get installed/loaded extensions
            if ($this->extensionConfiguration->get($this->extensionKey, 'featureExtensionList') != 0) {
                if ($this->extensionConfiguration->get($this->extensionKey, 'featureLoadedExtensionsOnly') != 0) {
                    $extensionList = $this->extensions->getInstalledExtensions();
                } else {
                    $extensionList = $this->extensions->getAvailableExtensions();
                }
                foreach ($extensionList as $extension) {
                    $data[] .= self::KEY_EXTENSION . ':' . $extension;
                }
            }
            // Get TYPO3 version
            if ($this->extensionConfiguration->get($this->extensionKey, 'featureTypo3Version') != 0) {
                $data[] = self::KEY_TYPO3 . ':' . self::KEY_VERSION . '-' . $this->typo3instance->getTypo3Version();
            }
            // Get application context
            if ($this->extensionConfiguration->get($this->extensionKey, 'featureApplicationContext') != 0) {
                $data[] = self::KEY_APPLICATION_CONTEXT . ':' .
                    strtolower($this->configuration->getApplicationContext());
            }
            // Get site name as configured
            if ($this->extensionConfiguration->get($this->extensionKey, 'featureSitename') != 0) {
                $data[] = self::KEY_SITENAME . ':' .
                    urlencode(trim(preg_replace('/[^a-zA-Z0-9\-\. ]/', '', $this->configuration->getSiteName())));
            }
            // Get PHP version number as major-minor-release value
            if ($this->extensionConfiguration->get($this->extensionKey, 'featurePhpVersion') != 0) {
                $data[] = self::KEY_PHP . ':' . self::KEY_VERSION . '-' . $this->server->getPhpVersion();
            }
            // Get server name (as configured in web server configuration) or HTTP HOST name
            if ($this->extensionConfiguration->get($this->extensionKey, 'featureServername') != 0) {
                $data[] = self::KEY_SERVERNAME . ':' . urlencode($this->server->getServerName());
            }
            // Get server timestamp and timezone
            if ($this->extensionConfiguration->get($this->extensionKey, 'featureTimestamp') != 0) {
                $data[] = self::KEY_TIMESTAMP . ':' . $this->server->getTimeStamp();
            }
        } else {
            $data[] = '# ACCESS DENIED';
            $data[] = self::KEY_MESSAGE . ':access denied';
        }

        // Add header to output, if not explicitly supressed
        if (isset($header)) {
            $data = array_merge([$header, chr(13)], $data);
        }

        $response = new Response();
        $response->getBody()->write(implode(PHP_EOL, $data) . PHP_EOL);
        return $response
            ->withHeader('Expires', 'Thu, 01 Jan ' . date('Y') . ' 00:00:00 GMT')
            ->withHeader('Last-Modified', gmdate('D, d M Y H:i:s') . ' GMT')
            ->withHeader('Cache-Control', 'no-cache, must-revalidate')
            ->withHeader('Pragma', 'no-cache')
            ->withHeader('Content-Type', 'text/plain; charset=utf8')
            ->withHeader('X-Robots-Tag', 'noindex, nofollow');
    }
}
