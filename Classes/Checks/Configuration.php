<?php
namespace SchamsNet\Nagios\Checks;
/**
 * This file is part of the TYPO3 CMS Extension "Nagios"
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

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class contains methods for configuration-related checks.
 * All configuration checks can be adjusted by an administrator or TYPO3 integrator.
 * They are not server- or system- or TYPO3-related.
 */
class Configuration {

	/**
	 * Returns the current application context.
	 * TYPO3 CMS provides three built-in contexts: Production, Development and Testing.
	 * https://docs.typo3.org/typo3cms/CoreApiReference/ApiOverview/Bootstrapping/Index.html
	 *
	 * The context can be set by using the environment varaible TYPO3_CONTEXT.
	 * For example in Apache: SetEnv TYPO3_CONTEXT Development
	 *
	 * @access	public
	 * @return	string		Application context as configured
	 */
	public function getApplicationContext() {
		return GeneralUtility::getApplicationContext();
	}

	/**
	 * Returns the site name as configured in typo3conf/LocalConfiguration.php
	 * For example: "My TYPO3 Website"
	 *
	 * @access	public
	 * @return	string		Site name
	 */
	public function getSiteName() {
		return $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'];
	}

    /**
     * Provides status information on the deprecation log, whether it's enabled
     * or not.
	 *
	 * Note: it was also considered to check if a certain file size is reached
	 * or exceeded. This feature is part of the sytem extension EXT:reports,
	 * but has not been implemented in EXT:nagios (yet).
	 *
	 * @access	public
	 * @return	string		Deprecation log status (enabled, disabled or unknown)
	 */
    public function getDeprecationLogStatus() {

		if(!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['enableDeprecationLog'])) {

			// Deprecation log settings are NOT configured This is very unusal,
			// because even if no setting has be configured in file LocalConfiguration.php,
			// TYPO3 provides a default value (which is "0", disabled).
			return 'unknown';
		}
		elseif( $GLOBALS['TYPO3_CONF_VARS']['SYS']['enableDeprecationLog'] === FALSE
		 || $GLOBALS['TYPO3_CONF_VARS']['SYS']['enableDeprecationLog'] === '0'
		 || $GLOBALS['TYPO3_CONF_VARS']['SYS']['enableDeprecationLog'] === 0) {

			// Deprecation log is explicitly disabled in file LocalConfiguration.php
			// (Install Tool).
			return 'disabled';
		}
		else {

			$deprecationLogFileName = GeneralUtility::getDeprecationLogFileName();
			$deprecationLogFileSize = 0;
			if(@file_exists($deprecationLogFileName)) {

				if(@is_readable($deprecationLogFileName)) {
					// analysing deprecation log file size is NOT implemented, see note above.
					$deprecationLogFileSize = @filesize($deprecationLogFileName);
				}

				// deprecation log file is enabled in file LocalConfiguration.php
				return 'enabled';
			}
			else {
				// 'file': The log file will be written to typo3conf/deprecation_[hash-value].log (default).
				// 'devlog': The log will be written to the development log.
				// 'console': The log will be displayed in the Backend's Debug Console.
				// The logging options can be combined by comma-separating them.

//				$statusDeprecationLog = explode(',', $GLOBALS['TYPO3_CONF_VARS']['SYS']['enableDeprecationLog']);
				return 'enabled';
			}
        }

		// it is impossible to reach this point
		return 'unknown';
    }
}
