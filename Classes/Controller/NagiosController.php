<?php
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

//use SchamsNet\Nagios\Checks\Server;
//use SchamsNet\Nagios\Checks\Typo3;
//use SchamsNet\Nagios\Checks\Configuration;
//use SchamsNet\Nagios\Checks\Extensions;

/**
 * Main controller
 */
class NagiosController
{
    /**
     * Constants used as keywords in output
     */
    const KEY_PHP = 'PHP';
    const KEY_TYPO3 = 'TYPO3';
    const KEY_EXTENSION = 'EXT';
    const KEY_SITENAME = 'SITENAME';
    const KEY_SERVERNAME = 'SERVERNAME';
    const KEY_APPLICATION_CONTEXT = 'APPLICATIONCONTEXT';
    const KEY_TIMESTAMP = 'TIMESTAMP';
    const KEY_DEPRECATION_LOG_STATUS = 'DEPRECATIONLOG';
    const KEY_DISKUSAGE = 'DISKUSAGE';
    const KEY_MESSAGE = 'MESSAGE';
    const KEY_VERSION = 'version';

    /**
     * Default keywords included in database details
     *
     * @access private
     * @var array
     */
    private $keywordsIncludedInDatabaseDetails = ['host', 'database'];

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
     * @var string // @TODO check data type
     */
    private $extensionConfiguration = null;

    /**
    * @access private
    * @var ServerRequestInterface
     */
    private $request = null;

    /**
     * Object Manager
     *
     * @access private
     * @var object
     */
    private $objectManager = null;

    /**
     * Server object (see: SchamsNet\Nagios\Checks\Server.php)
     *
     * @access private
     * @var object
     */
    private $server = null;

    /**
     * TYPO3 instance object (see: SchamsNet\Nagios\Checks\Typo3.php)
     *
     * @access private
     * @var object
     */
    private $typo3instance = null;

    /**
     * Extension object (see: SchamsNet\Nagios\Checks\Extensions.php)
     *
     * @access private
     * @var object
     */
    private $extensions = null;

    /**
     * Configuration object (see: SchamsNet\Nagios\Checks\Configuration.php)
     *
     * @access private
     * @var object
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

        /** @var $objectManager TYPO3\CMS\Extbase\Object\ObjectManager */
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var $server SchamsNet\Nagios\Checks\Server */
/*
        $this->server = $this->objectManager->get(Server::class);
*/
        /** @var $typo3instance SchamsNet\Nagios\Checks\Typo3 */
/*
        $this->typo3instance = $this->objectManager->get(Typo3::class);
*/
        /** @var $extensions SchamsNet\Nagios\Checks\Extensions */
/*
        $this->extensions = $this->objectManager->get(Extensions::class);
*/
        /** @var $configuration  SchamsNet\Nagios\Checks\Configuration */
/*
        $this->configuration = $this->objectManager->get(Configuration::class);
*/
    }

    /**
     * Dispatcher method
     *
     * @access public
     * @return Response
     */
    public function execute()
    {
        $data = [];

        // Proxy servers are *NOT* taken into account by default when checking client access, but if
        // extension security exception has been explicitly confirmed (securityProxyHeaders = 1),
        // HTTP headers typically passed through by proxy servers are checked in addition to
        // $_SERVER['REMOTE_ADDR']
        $takeProxyServerIntoAccount = false;
        if ($this->extensionConfiguration->get($this->extensionKey, 'securityProxyHeaders') == 1) {
            $takeProxyServerIntoAccount = true;
        }

        // Send header if not configured as suppressed
        if ($this->extensionConfiguration->get($this->extensionKey, 'securitySupressHeader') != 1) {
//            $version = $this->extensions->getExtensionVersion($this->extensionKey);
            $version = '3.0.0'; // @TODO determine version of EXT:nagios
            $data[] = '# Nagios TYPO3 Monitoring Version ' . $version . ' - https://schams.net/nagios';
            $data[] = '';
        }

        // ...
        $isValidClient = AccessUtility::isValidClient(
            $this->extensionConfiguration->get($this->extensionKey, 'securityNagiosServerList'),
            $this->extensionConfiguration->get($this->extensionKey, 'securityProxyHeaders'),
            $this->request
        );

        if ($isValidClient === true) {
            $data[] = 'valid';
        } else {
            $data[] = '# ACCESS DENIED';
            $data[] = self::KEY_MESSAGE . ':access denied';
        }

/*
        if ($isValidNagiosServer === true) {
            if ($this->extensionConfiguration['featureExtensionList'] != 0) {
                if ($this->extensionConfiguration['featureLoadedExtensionsOnly'] != 0) {
                    $extensionList = $this->extensions->getInstalledExtensions($objectManager);
                } else {
                    $extensionList = $this->extensions->getAvailableExtensions($objectManager);
                }
                foreach ($extensionList as $extension) {
                    $data[] .= self::KEY_EXTENSION . ':' . $extension;
                }
            }

            if ($this->extensionConfiguration['featurePHPVersion'] != 0) {
                $data[] = self::KEY_PHP . ':' . self::KEY_VERSION . '-' . $this->server->getPhpVersion();
            }

            if ($this->extensionConfiguration['featureTYPO3Version'] != 0) {
                $data[] = self::KEY_TYPO3 . ':' . self::KEY_VERSION . '-' . $this->typo3instance->getTypo3Version();
            }

            if ($this->extensionConfiguration['featureApplicationContext'] != 0) {
                $data[] = self::KEY_APPLICATION_CONTEXT . ':' .
                    strtolower($this->configuration->getApplicationContext());
            }

            if ($this->extensionConfiguration['featureSitename'] != 0) {
                $data[] = self::KEY_SITENAME . ':' .
                    urlencode(trim(preg_replace('/[^a-zA-Z0-9\-\. ]/', '', $this->configuration->getSiteName())));
            }

            if ($this->extensionConfiguration['featureServername'] != 0) {
                $data[] = self::KEY_SERVERNAME . ':' . urlencode($this->server->getServerName());
            }

            if ($this->extensionConfiguration['featureDeprecationLog'] != 0) {
                $data[] = self::KEY_DEPRECATION_LOG_STATUS . ':' . $this->configuration->getDeprecationLogStatus();
            }
            if ($this->extensionConfiguration['featureDatabaseDetails'] != 0) {
                $databaseDetails = $this->configuration->getDatabaseDetails($this->keywordsIncludedInDatabaseDetails);
                if (is_array($databaseDetails) && count($databaseDetails) > 0) {
                    $data[] = implode(PHP_EOL, $databaseDetails);
                }
            }

            if ($this->extensionConfiguration['featureTimestamp'] != 0) {
                $data[] = self::KEY_TIMESTAMP . ':' . $this->server->getTimeStamp();
            }

            if ($this->extensionConfiguration['featureCheckDiskUsage'] != 0) {
                $data[] = self::KEY_DISKUSAGE . ':' . $this->server->getDiskUsage();
            }
        } else {
            $data = array_filter($data);
            $data[] = '# ACCESS DENIED';
            $data[] = self::KEY_MESSAGE . ':access denied';
        }
*/

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

    /**
     * Set server request interface
     *
     * @access public
     * @param ServerRequestInterface
     * @return void
     */
    public function setServerRequest(ServerRequestInterface $request): void
    {
        $this->request = $request;
    }

    /**
     * Initialises extension configuration array
     *
     * @access private
     * @return array Extension configuration array
     */
    private function initExtensionConfiguration()
    {
        return [
            'featureTYPO3Version' => true,
            'featurePHPVersion' => true,
            'featureExtensionList' => true,
            'featureActivatedExtensionsOnly' => false,
            'featureApplicationContext' => true,
            'featureDeprecationLog' => true,
            'featureDatabaseDetails' => false,
            'featureTimestamp' => true,
            'featureCheckDiskUsage' => false,
            'featureSitename' => false,
            'featureServername' => false,
            'securityNagiosServerList' => '127.0.0.1',
            'securitySupressHeader' => false,
            'securityProxyHeaders' => false,
        ];
    }
}
