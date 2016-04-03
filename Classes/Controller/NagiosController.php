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

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

use SchamsNet\Nagios\Access\Access;
use SchamsNet\Nagios\Checks\Server;
use SchamsNet\Nagios\Checks\Typo3;
use SchamsNet\Nagios\Checks\Configuration;
use SchamsNet\Nagios\Checks\Extensions;

/**
 * Extension ID (eID) script "NagiosController"
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
	 * Extension key
	 *
	 * @access private
	 * @var string
	 */
	private $extensionKey = 'nagios';

	/**
	 * Object Manager
	 *
	 * @access private
	 * @var object
	 */
	private $objectManager = NULL;

	/**
	 * Server object (see: SchamsNet\Nagios\Checks\Server.php)
	 *
	 * @access private
	 * @var object
	 */
	private $server = NULL;

	/**
	 * TYPO3 instance object (see: SchamsNet\Nagios\Checks\Typo3.php)
	 *
	 * @access private
	 * @var object
	 */
	private $typo3instance = NULL;

	/**
	 * Extension object (see: SchamsNet\Nagios\Checks\Extensions.php)
	 *
	 * @access private
	 * @var object
	 */
	private $extensions = NULL;

	/**
	 * Configuration object (see: SchamsNet\Nagios\Checks\Configuration.php)
	 *
	 * @access private
	 * @var object
	 */
	private $configuration = NULL;

	/**
	 * Default constructor
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		// retrieve extension configuration data
		$this->extensionConfiguration = array_merge($this->initExtensionConfiguration(), $this->getExtensionConfiguration());

		/**
		 * Object Manager
		 * @var $objectManager ObjectManager
		 */
		$this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);

		/**
		 * Server object
		 * @var $server Server
		 */
		$this->server = $this->objectManager->get(Server::class);

		/**
		 * TYPO3 instance object
		 * @var $typo3instance Typo3
		 */
		$this->typo3instance = $this->objectManager->get(Typo3::class);

		/**
		 * Extension object
		 * @var $extensions Extensions
		 */
		$this->extensions = $this->objectManager->get(Extensions::class);

		/**
		 * Configuration object
		 * @var $configuration Configuration
		 */
		$this->configuration = $this->objectManager->get(Configuration::class);
	}

	/**
	 * Dispatcher method
	 *
	 * @access	public
	 * @param	ServerRequestInterface	$request server request interface
	 * @param	ResponseInterface		$response response
	 *
	 * @return	ResponseInterface
	 */
	public function execute(ServerRequestInterface $request, ResponseInterface $response)
	{
		$data = array();

		// Proxy servers are *NOT* taken into account by default when checking client access, but if
		// extension security exception has been explicitly confirmed (securityProxyHeaders = 1),
		// HTTP headers typically passed through by proxy servers are checked in addition to
		// $_SERVER['REMOTE_ADDR']
		$takeProxyServerIntoAccount = FALSE;
		if ($this->extensionConfiguration['securityProxyHeaders'] == 1) {
			$takeProxyServerIntoAccount = TRUE;
		}

		// send header if not configured as suppressed
		if ($this->extensionConfiguration['securitySupressHeader'] != 1) {
			$data[] = '# Nagios TYPO3 Monitoring Version ' . $this->extensions->getExtensionVersion($this->extensionKey) . ' - https://schams.net/nagios';
			$data[] = '';
		}

		// ...
		if (Access::isValidNagiosServer($this->extensionConfiguration['securityNagiosServerList'], $takeProxyServerIntoAccount) === TRUE) {

			// ...
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
				$data[] = self::KEY_APPLICATION_CONTEXT . ':' . strtolower($this->configuration->getApplicationContext());
			}

			if ($this->extensionConfiguration['featureSitename'] != 0) {
				$data[] = self::KEY_SITENAME . ':' . urlencode(trim(preg_replace('/[^a-zA-Z0-9\-\. ]/', '', $this->configuration->getSiteName())));
			}

			if ($this->extensionConfiguration['featureServername'] != 0) {
				$data[] = self::KEY_SERVERNAME . ':' . urlencode($this->server->getServerName());
			}

			if ($this->extensionConfiguration['featureDeprecationLog'] != 0) {
				$data[] = self::KEY_DEPRECATION_LOG_STATUS . ':' . $this->configuration->getDeprecationLogStatus();
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
	 * Returns extension configuration (as configured in TYPO3 CMS Extension Manager)
	 *
	 * @access	private
	 * @return	array		Extension configuration (key: keyword, value: value)
	 */
	private function getExtensionConfiguration()
	{
		$defaultExtensionConfiguration = $this->initExtensionConfiguration();
		if (isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extensionKey])) {
			$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extensionKey]);
			if (is_array($extensionConfiguration)) {
				foreach ($extensionConfiguration as $key => $_) {
					if (!array_key_exists($key, $defaultExtensionConfiguration)) {
						unset($extensionConfiguration[$key]);
					}
				}
				return $extensionConfiguration;
			}
		}
		return array();
	}

	/**
	 * Initialises extension configuration array
	 *
	 * @access	private
	 * @return	array		Extension configuration array
	 */
	private function initExtensionConfiguration()
	{
		return array(
			'featureTYPO3Version' => TRUE,
			'featurePHPVersion' => TRUE,
			'featureExtensionList' => TRUE,
			'featureActivatedExtensionsOnly' => FALSE,
			'featureApplicationContext' => TRUE,
			'featureDeprecationLog' => TRUE,
			'featureTimestamp' => TRUE,
			'featureCheckDiskUsage' => FALSE,
			'featureSitename' => FALSE,
			'featureServername' => FALSE,
			'securityNagiosServerList' => '127.0.0.1',
			'securitySupressHeader' => FALSE,
			'securityProxyHeaders' => FALSE,
		);
	}
}
