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

if(!defined ('TYPO3_MODE')) {
 	die('Access denied.');
}

// register eID
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['nagios'] = 'EXT:'.$_EXTKEY.'/classes/class.tx_nagios_eid.php';

// extend hook for showing admin error messages in TYPO3 CMS backend
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_befunc.php']['displayWarningMessages'][] = 'EXT:nagios/classes/class.tx_nagios_befunc.php:tx_nagios_befunc';

?>
