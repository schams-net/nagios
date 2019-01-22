<?php
namespace SchamsNet\Nagios\Utility;

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

use TYPO3\CMS\Core\Http\NormalizedParams;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Provides methods to verify that accessing instance (client) is allowed
 * to retrieve information from the instance (to prevent information disclosure).
 */
class AccessUtility
{
    /**
     * List of valid proxy/cache/load balancer HTTP headers
     * (state values in upper case only!)
     *
     * @access private
     * @var array
     */
    private const VALID_PROXY_HEADERS = ['X_REAL_IP', 'X_FORWARDED_FOR'];

    /**
     * List of invalid IP addresses
     *
     * @access private
     * @var array
     */
    private const INVALID_IP_ADDRESSES = ['*.*.*.*', '0.0.0.0'];

    /**
     * Returns ...
     * ...
     * @param string ...
     * @param bool ...
     * @param ServerRequestInterface ...
     * @return bool ...
     */
    public static function isValidClient(
        string $securityNagiosServerList,
        bool $takeProxyServerIntoAccount,
        ServerRequestInterface $request
    ) {
        $normalizedParams = $request->getAttribute('normalizedParams');
        $remoteAddress = $normalizedParams->getRemoteAddress();

        if (isset($securityNagiosServerList)
            && !empty($securityNagiosServerList)
            && is_string($securityNagiosServerList)) {
            // Make sure, extension configuration only contains valid entries
            // and hostnames are resolved to IP addresses
            $securityNagiosServerList = self::resolveHostnamesInList($securityNagiosServerList);

            // check remote IP address
            if (GeneralUtility::cmpIP($remoteAddress, $securityNagiosServerList) === true) {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns comma-separated list of IP addresses, with hostnames resolved to IP addresses
     *
     * @access public
     * @param string Comma-separated list of IP addresses and hostnames (wildcard allowed)
     * @return string Comma-separated list of IP addresses (wildcard allowed)
     */
    public static function resolveHostnamesInList($list)
    {
        $resolvedList = [];
        $list = GeneralUtility::trimExplode(',', $list, true);
        foreach ($list as $item) {
            if (GeneralUtility::validIP(str_replace('*', '0', $item))) {
                if (!in_array($item, self::INVALID_IP_ADDRESSES)) {
                    // Item is a valid IP address
                    $resolvedList[] = $item;
                }
            } else {
                // Convert hostname to IP address
                $hosts = gethostbynamel($item);
                if ($hosts) {
                    $resolvedList = array_merge($resolvedList, $hosts);
                }
            }
        }

        // Remove duplicates
        $resolvedList = array_unique($resolvedList);

        // Return comma-separated list of items
        return implode(',', $resolvedList);
    }
}
