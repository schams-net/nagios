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
 * Class to handle system commands
 *
 * @author		Michael Schams <schams.net>
 * @package		TYPO3
 * @subpackage	tx_nagios
 *
 * public static function exec($command, &$output = NULL, &$returnValue = 0)
 *	Wrapper function for PHP exec() (original: t3lib/utility/class.t3lib_utility_command.php since TYPO3 CMS version 4.5.0)
 *
 */
class tx_nagios_utility_Command {

	var $scriptRelPath = 'classes/class.tx_nagios_utility_command.php';
	var $extKey        = 'nagios';

	/**
	 * Wrapper function for PHP exec() function
	 * Needs to be central to have better control and possible fix for issues
	 * (original: t3lib/utility/class.t3lib_utility_command.php since TYPO3 CMS version 4.5.0)
	 * Based on some code in the TYPO3 core by Steffen Kamper <steffen@typo3.org>
	 *
	 * @static
	 * @param 	string			$command
	 * @param	NULL/array		$output
	 * @param	integer			$returnValue
	 * @return	NULL/array
	 */
	public static function exec($command, &$output = NULL, &$returnValue = 0) {
		$lastLine = exec($command, $output, $returnValue);
		return $lastLine;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/nagios/classes/class.tx_nagios_utility_command.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/nagios/classes/class.tx_nagios_utility_command.php']);
}

?>
