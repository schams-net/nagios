<?php
/**
 * This file is part of the TYPO3 CMS Extension "Nagios"
 * Author: Michael Schams - https://schams.net
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

/**
 * Class triggered by eID calls
 *
 * @author		Michael Schams <schams.net> and Christian Lerrahn
 * @package		TYPO3
 * @subpackage	tx_nagios
 *
 * public function main()
 *	The main method of the extension.
 *
 * private function getExtensionConfiguration()
 *	Returns extension configuration (via TYPO3 CMS Extension Manager).
 *
 * private function getStaticMarkers()
 *	Returns static markers.
 *
 */

// include class tx_nagios which builds main functions
t3lib_div::requireOnce(t3lib_extMgm::extPath('nagios').'/classes/class.tx_nagios.php');

// compatibility with TYPO3 CMS version 4.1.x and 4.2.x
if(tx_nagios::convertVersionNumberToInteger(TYPO3_version) < 4003000) {
	if(class_exists('tslib_cObj') === FALSE && is_readable(PATH_tslib.'class.tslib_content.php')) {
		t3lib_div::requireOnce(PATH_tslib.'class.tslib_content.php');
	}
	if(class_exists('language') === FALSE && is_readable(PATH_typo3.'sysext/lang/lang.php')) {
		t3lib_div::requireOnce(t3lib_extMgm::extPath('lang', 'lang.php'));
	}
}

class tx_nagios_eid {

	var $scriptRelPath = 'classes/class.tx_nagios_eid.php';
	var $extKey        = 'nagios';

	/**
	 * Details about THIS extension (e.g. title, version, etc.), set in constructor.
	 *
	 * @var array
	 */
	private $extensionDetails = array();

	/**
	 * String (usually a character) used to separate each element.
	 *
	 * @var string
	 */
	private $elementSeparator = "\n";

	/**
	 * This variable enables/disables debug mode.
	 * This setting can be configured in TYPO3 CMS BE (flexforms).
	 *
	 * @var resource
	 */
	private $debugMode = FALSE;

	/**
	 * Extension configuration defined by flexforms in TYPO3 CMS backend
	 *
	 * @var array
	 */
	private $flexFormConfiguration = array();

	/**
	 * Extension configuration defined in Extension Manager (TYPO3 CMS backend)
	 *
	 * @var array
	 */
	private $extensionConfiguration = array();

	/**
	 * Language object (required to access local labels)
	 *
	 * @var object
	 */
	private $language;

	/**
	 * Nagios object (instantiated in Contructor method)
	 *
	 * @var object
	 */
	private $objNagios;

	/**
	 * Local cObj (required for marker substitution)
	 *
	 * @var object
	 */
	private $cObj;


	/**
	 * Constructor method.
	 *
	 * @access	public
	 * @return	void
	 */
	public function __construct() {

		$this->objNagios = t3lib_div::makeInstance('tx_nagios');

		// get details about THIS extension
		$this->extensionDetails = $this->objNagios->getExtensionDetails($this->extKey);
		if($this->extensionDetails === FALSE) {
			$this->extensionDetails = array('title' => 'Nagios', 'version' => 'unknown');
		}

		// create local cObj
		$this->cObj = t3lib_div::makeInstance('tslib_cObj');

		// create language object to retrieve labels (keywords) - TYPO3 CMS version 4.1.x compatible
		$GLOBALS['LANG'] = t3lib_div::makeInstance('language');
		$GLOBALS['LANG']->init('default');
		$GLOBALS['LANG']->includeLLFile('EXT:'.$this->extKey.'/lang/locallang.xml');
		$this->language = $GLOBALS['LANG'];

		// eID method requires a database connect in TYPO3 < 6.1
		if(tx_nagios::convertVersionNumberToInteger(TYPO3_version) < 6001000) {
			tslib_eidtools::connectDB();
		}
	}


	/**
	 * The main method of the extension.
	 *
	 * @access	public
	 * @return	string	Information about the TYPO3 CMS instance according to extension configuration
	 */
	public function main() {

		$this->extensionConfiguration = array_merge($this->objNagios->initExtensionConfiguration(), $this->getExtensionConfiguration());
		$static_markers = $this->getStaticMarkers();

		$data = array();

		// get version of Nagios plugin (client) if passed by GET/POST argument
		$nagiosPluginVersion = $this->objNagios->getNagiosPluginVersion();

		if($this->extensionConfiguration['featureDebugMode'] == 1) {
			$this->debugMode = TRUE;
		}

		// do *not* take proxy servers into account by default when checking client access, but if
		// extension security exception has been explicitly confirmed (securityProxyHeaders = 1),
		// HTTP headers typically passed through by proxy servers are investigated in addition to
		// $_SERVER['REMOTE_ADDR']
		if($this->extensionConfiguration['securityProxyHeaders'] != 1) {
			$this->objNagios->takeProxyServerIntoAccount(FALSE);
		}

		if($this->objNagios->isValidNagiosServer($this->extensionConfiguration['securityNagiosServerList']) === FALSE) {

			// remote (Nagios?) server is not allowed to retrieve information about this TYPO3 CMS server.
			// generate some further explanations (problem description) as comments.
			$data[] = '# '.$this->language->getLL('access_denied_line01');
			$data[] = '# '.$this->language->getLL('access_denied_line02');
			$data[] = '# '.$this->language->getLL('access_denied_line03');
			$data[] = '# (extension configuration via TYPO3 CMS Extension Manager)';
			$data[] = $this->language->getLL('keyword_message').':access denied';
		}
		else {
			// all security checks successfully passed - Nagios server is allowed to retrieve data

			if($this->extensionConfiguration['featureTYPO3Version'] != 0) {
				$data[] = $this->language->getLL('keyword_typo3').':version-'.$this->objNagios->getTypo3Version();
			}
			if($this->extensionConfiguration['featurePHPVersion'] != 0) {
				$data[] = $this->language->getLL('keyword_php').':version-'.$this->objNagios->getPhpVersion();
			}

			// 'featureLoadedExtensionsOnly' must be set *prior* $this->objNagios->getExtensionVersions()
			if($this->extensionConfiguration['featureLoadedExtensionsOnly'] == 1) {
				$this->objNagios->setLoadedExtensionsOnly(TRUE);
			}
			if($this->extensionConfiguration['featureExtensionList'] != 0) {
				$data[] = implode($this->elementSeparator, $this->objNagios->getExtensionVersions($this->language->getLL('keyword_extension')));
			}
			if($this->extensionConfiguration['featureExtensionDependencyTypo3'] != 0) {
				$extensionDependencyIssues = $this->objNagios->getExtensionDependency($this->language->getLL('keyword_extensiondependencytypo3'), tx_nagios::TX_NAGIOS_EXTENSION_DEPENDENCY_TYPO3);
				if(is_array($extensionDependencyIssues) && count($extensionDependencyIssues) > 0) {
					$data[] = implode($this->elementSeparator, $extensionDependencyIssues);
				}
			}
			if($this->extensionConfiguration['featureSitename'] != 0) {
				$data[] = $this->language->getLL('keyword_sitename').':'.$this->objNagios->getSitename();
			}
			if($this->extensionConfiguration['featureServername'] != 0) {
				$data[] = $this->language->getLL('keyword_servername').':'.$this->objNagios->getServername();
			}
			if($this->extensionConfiguration['featureBasicDatabaseDetailsTables'] != 0) {
				$data[] = $this->language->getLL('keyword_databasetables').':'.$this->objNagios->getDatabaseDetailsTables();
			}
			if($this->extensionConfiguration['featureBasicDatabaseDetailsProcesslist'] != 0) {
				$database_processlist = $this->objNagios->getDatabaseDetailsProcesses();
				if($database_processlist !== FALSE && is_numeric($database_processlist)) {
					$data[] = $this->language->getLL('keyword_databaseprocesslist').':'.$database_processlist;
				}
			}
			if($this->extensionConfiguration['featureTimestamp'] != 0) {
				$data[] = $this->language->getLL('keyword_timestamp').':'.date('U-T');
			}
			if($this->extensionConfiguration['featureDeprecationLog'] != 0) {
				$data[] = $this->language->getLL('keyword_deprecationlog').':'.$this->objNagios->getDeprecationLogSetting();
			}
			if($this->extensionConfiguration['featureDonationNotice'] != 0) {
				$data[] = $this->language->getLL('keyword_donationnotice').':'.$this->objNagios->getDonationNoticeSetting();
			}
			if($this->extensionConfiguration['featureCheckDiskUsage'] != 0) {
				$data[] = $this->language->getLL('keyword_diskusage').':'.$this->objNagios->getDiskUsage();
			}
		}

		// glue single elements together, using $this->elementSeparator variable
		$data = implode($this->elementSeparator, $data);

		// add header ("Nagios TYPO3 Monitoring Version x.x.x...") if not permitted in extension configuration
		$header = '';
		if($this->extensionConfiguration['securitySupressHeader'] != 1) {
			$header.= '# '.$this->extensionDetails['title'].' Version '.$this->extensionDetails['version'].' - https://schams.net/nagios' . PHP_EOL;

			if($nagiosPluginVersion !== FALSE && is_string($nagiosPluginVersion) && !empty($nagiosPluginVersion)) {
				$header.= '# Nagios Plugin Version '.$nagiosPluginVersion.' (IP: ' . t3lib_div::getIndpEnv('REMOTE_ADDR') . ')' . PHP_EOL;
			}
			$header.= "\n";
		}

//		if(!headers_sent() && error_get_last() == NULL) {
		if(!headers_sent()) {

			// force text/plain in HTTP header
			header('Content-Type: text/plain');

			// disable client side caching, e.g. proxy servers (very basic only)
			header('Cache-Control: no-cache, must-revalidate');
			header('Expires: Sat, 01 Jan 2011 00:00:00 UTC');
		}

		// final output: header (if available) + data (with static markers replaced)
		echo $header.$this->cObj->substituteMarkerArray($data, $static_markers);
	}


	/**
	 * Returns extension configuration (via TYPO3 CMS Extension Manager).
	 *
	 * @access	private
	 * @return	array	Extension configuration (key: keyword, value: value)
	 */
	private function getExtensionConfiguration() {

		if(isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey])) {
			return unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);
		}
		return array();
	}


	/**
	 * Returns static markers.
	 *
	 * @access	private
	 * @return	array	Array with static markers (key: keyword, value: value)
	 */
	private function getStaticMarkers() {

		return array(
		);
	}
}

$nagiosInfo = t3lib_div::makeInstance('tx_nagios_eid');
$nagiosInfo->main();
