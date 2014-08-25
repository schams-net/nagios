<?php
/**
 * This file is part of the TYPO3 CMS Extension "Nagios"
 * Author: Michael Schams - http://schams.net
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
 * TYPO3 backend functions for the 'nagios' extension.
 *
 * @author		Michael Schams <schams.net>
 * @package		TYPO3
 * @subpackage	tx_nagios
 *
 * public function displayWarningMessages_postProcess(&$warning)
 *	Generate warning message to admin users if misconfiguration of "Nagios server list" was detected
 *
 */
class tx_nagios_befunc {

	var $scriptRelPath = 'classes/class.tx_nagios_befunc.php';
	var $extKey        = 'nagios';

	/**
	 * List if "dangerous" IP addresses
	 *
	 * var array
	 */
	var $invalidIpAddresses = array('0.0.0.0', '*.*.*.*');

	/**
	 * Generate warning message to admin users if misconfiguration of "Nagios server list" was detected.
	 * This method is triggered by a hook for showing admin error messages in TYPO3 CMS backend
	 *
	 * @param	array		$warning: reference to array with warning messages
	 * @return	void
	 */
	public function displayWarningMessages_postProcess(&$warning) {

		if (isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey])
		 && is_string($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey])
		 && !empty($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey])) {

			$extConf = @unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);
			if (is_array($extConf) && array_key_exists('securityNagiosServerList', $extConf)) {

				// check for an empty list
				$nagiosServerList = trim(preg_replace('/[^0-9\.]/', '', $extConf['securityNagiosServerList']));
				if (empty($nagiosServerList)) {
					$warning[$this->extKey.':'.__CLASS__] = sprintf($GLOBALS['LANG']->sL('LLL:EXT:nagios/lang/locallang.xml:nagios_misconfiguration_invalid_ip_address'));
				}

				// check for invalid or "dangerous" IP addresses
				$nagiosServerList = explode(',', $extConf['securityNagiosServerList']);
				foreach($nagiosServerList as $ipAddress) {
					$ipAddress = trim($ipAddress);
					if (!empty($ipAddress)
					 && (preg_match('/^[0-9]{1,3}\.[0-9\*]{1,3}\.[0-9\*]{1,3}\.[0-9\*]{1,3}$/', $ipAddress) == FALSE
					 || in_array($ipAddress, $this->invalidIpAddresses))) {
						$warning[$this->extKey.':'.__CLASS__] = sprintf($GLOBALS['LANG']->sL('LLL:EXT:nagios/lang/locallang.xml:nagios_misconfiguration_invalid_ip_address'));
					}
				}
			}
		}
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/nagios/classes/class.tx_nagios_befunc.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/nagios/classes/class.tx_nagios_befunc.php']);
}
