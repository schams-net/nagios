<?php
namespace SchamsNet\Nagios\Access;
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
 * Provides methods to verify that accessing instance (client) has access to the TYPO3 CMS server
 * and is allowed to retrieve information from the instance (to prevent information disclosure).
 */
class Access {

	/**
	 * List of valid proxy/cache/load balancer HTTP headers
	 * (state values in upper case only!)
	 */
	const VALID_PROXY_HEADERS = array('X_REAL_IP', 'X_FORWARDED_FOR');

	/**
	 * List of invalid IP addresses
	 */
	const INVALID_IP_ADDRESSES = array('*.*.*.*', '0.0.0.0');

	/**
	 * Returns TRUE if list of valid Nagios servers contains the IP address of the requesting server (remote address).
	 * In other words: method to check if Nagios server is allowed to retrieve information from TYPO3 CMS instance.
	 * Wildcards can be used, e.g. 123.45.*.*
	 *
	 * @access	public
	 * @param	string		$securityNagiosServerList: comma-separated list of IP addresses of valid Nagios servers
	 * @param	string		$takeProxyServerIntoAccount: controls, if additional HTTP headers should be checked (default: FALSE)
	 * @return	boolean		TRUE if valid remote server, FALSE if access denied
	 */
	static public function isValidNagiosServer($securityNagiosServerList = NULL, $takeProxyServerIntoAccount = FALSE) {

		if(isset($securityNagiosServerList)
		  && !empty($securityNagiosServerList)
		  && is_string($securityNagiosServerList)) {

			// make sure, extension configuration only contains valid entries
			// and hostnames are resolved to IP addresses
			$securityNagiosServerList = self::resolveHostnamesInList($securityNagiosServerList);

			// check remote IP address
			if(GeneralUtility::cmpIP(GeneralUtility::getIndpEnv('REMOTE_ADDR'), $securityNagiosServerList) === TRUE) {
				return TRUE;
			}

			// check if HTTP headers exist, which are typical for a proxy/cache/load balancer.
			// Note: PHP internal functions such as apache_request_headers() or getenv() exist
			// but the following code is safer.
			// TYPO3's internal GeneralUtility::getIndpEnv() only supports some specific HTTP
			// headers, but not X-Forwarded-For for example.
			if($takeProxyServerIntoAccount === TRUE) {
				foreach($_SERVER as $httpHeaderKey => $httpHeaderValue) {
					$httpHeaderKey = preg_replace('/^HTTP_/', '', trim(strtoupper($httpHeaderKey)));
					if( is_string($httpHeaderKey) && !empty($httpHeaderKey)
					 && in_array($httpHeaderKey, self::VALID_PROXY_HEADERS)
					 && is_string($httpHeaderValue) && !empty($httpHeaderValue)
					 && GeneralUtility::validIPv4($httpHeaderValue) ) {
						if(GeneralUtility::cmpIP($httpHeaderValue, $securityNagiosServerList) === TRUE) {
							return TRUE;
						}
					}
				}
			}

			// access denied
			return FALSE;
		}

		// extension configuration does not restrict remote Nagios servers
		// (same as using "*" as configuration value) - this is a security risk!
		return FALSE;
	}

	/**
	 * Returns comma-separated list of IP addresses, with hostnames resolved to IP addresses
	 *
	 * @access	public
	 * @param	string	$list: comma-separated list of IP addresses and hostnames (wildcard allowed)
	 * @return	string	Comma-separated list of IP addresses (wildcard allowed)
	 */
	public function resolveHostnamesInList($list) {

		$resolvedList = array();
		$list = GeneralUtility::trimExplode(',', $list, TRUE);
		foreach($list as $item) {
			if(GeneralUtility::validIP(str_replace('*', '0', $item))) {
				if(!in_array($item, self::INVALID_IP_ADDRESSES)) {
					// item is a valid IP address
					$resolvedList[] = $item;
				}
			}
			else {

				// convert hostname to IP address
				$hosts = gethostbynamel($item);
				if($hosts) {
					$resolvedList = array_merge($resolvedList, $hosts);
				}
			}
		}

		// remove duplicates
		$resolvedList = array_unique($resolvedList);

		// return comma-separated list of items
		return implode(',', $resolvedList);
	}
}
