<?php
namespace SchamsNet\Nagios\Checks;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\CommandUtility;

/**
 * Class contains methods for server-related checks, such as PHP version.
 * Server-related configurations usually require system administrator privileges
 * and can not be changed/adjusted by a TYPO3 integrator.
 */
class Server
{
	/**
	 * Returns PHP version as major-minor-release value (values such as "5.6.7-2ubuntu5.6" gets cleaned up)
	 * Example: 5.6.7
	 *
	 * @access public
	 * @return string
	 */
	public function getPhpVersion()
	{
		return substr(PHP_VERSION, 0, strpos(PHP_VERSION . '-', '-'));
	}

	/**
	 * Returns server name (as configured in web server configuration) or HTTP HOST name
	 *
	 * This method tries to get the information via GeneralUtility::getIndpEnv() first,
	 * then $_SERVER[], because getIndpEnv() offers a limited set of server data only.
	 *
	 * @access public
	 * @return string server name, host name or "not-supported" otherwise
	 */
	public function getServerName()
	{
		$serverVariables = array('SERVER_NAME', 'TYPO3_HOST_ONLY', 'HTTP_HOST');
		foreach ($serverVariables as $variable) {
			$value = GeneralUtility::getIndpEnv($variable);
			if (is_string($value) && !empty($value)) {
				return $value;
			} else {
				$value = $_SERVER[$variable];
				if (is_string($value) && !empty($value)) {
					return $value;
				}
			}
		}
		return 'not-supported';
	}

	/**
	 * Returns current timestamp and timezone setting
	 * Example:
	 *
	 * @return string
	 */
	public function getTimeStamp()
	{
		return date('U-T');
	}

	/**
	 * Determines the size of current disk usage if possible (requires *nix system)
	 * Note: the disk usage determined by this method is not 100% reliable.
	 * If the web server user (e.g. 'www-data') does not have access to all
	 * subdirectories of PATH_site, not all data is taken into account. Also,
	 * system can store some files *outside* of this directory.
	 *
	 * @access	public
	 * @return	mixed	Current amount of DB processes (string) or FALSE (bool) if an error occured
	 */
	public function getDiskUsage()
	{
		if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {

			// Note: CommandUtility::getCommand() returns FALSE even if the command
			// was found but is not executable. If open_basedir is enabled, the path
			// to 'du' can be defined in $TYPO3_CONF_VARS[SYS][binSetup] (see Install
			// Tool)
			$diskUsageCommand = CommandUtility::getCommand('du');

			if (is_string($diskUsageCommand) && !empty($diskUsageCommand) && is_executable($diskUsageCommand)) {
				$diskUsageCommand .= ' --summarize --block-size=1 ' . escapeshellarg(PATH_site) . ' 2>&1';
				$diskUsageResult = CommandUtility::exec($diskUsageCommand);
				return preg_replace('/^([0-9]*).*$/', '$1', $diskUsageResult);
			}
		}
		// Error: *nix command 'du' not available or not executable
		return 'not-supported';
	}
}
