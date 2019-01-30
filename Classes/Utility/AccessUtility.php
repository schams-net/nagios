<?php
declare(strict_types = 1);
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
     * Checks, if the HTTP request originated from a client, that is
     * allowed to access details of the TYPO3 instance. The "client"
     * is usually a Nagios server.
     *
     * @param string $serverList Comma-separated list of IP addresses and hostnames (as configured)
     * @param string $proxyServer If set to "true" (string will be casted), proxy servers are taken into account
     * @param ServerRequestInterface $request PSR-7 server request interface
     * @return bool Returns "true", if the requests originates from a valid client, otherwise "false"
     */
    public static function isValidClient(string $serverList, string $proxyServer, ServerRequestInterface $request): bool
    {
        /** @var NormalizedParams $normalizedParams */
        $normalizedParams = $request->getAttribute('normalizedParams');
        $remoteAddress = $normalizedParams->getRemoteAddress();

        if (isset($serverList)
            && !empty($serverList)
            && is_string($serverList)) {
            // Make sure, extension configuration only contains valid entries
            // and hostnames are resolved to IP addresses
            $serverList = self::resolveHostnamesInList($serverList);

            // check remote IP address
            if (GeneralUtility::cmpIP($remoteAddress, $serverList) === true) {
                return true;
            }

            // Proxy servers are *NOT* taken into account by default when checking client access, but if
            // extension security exception has been explicitly confirmed (securityProxyHeaders = 1),
            // HTTP headers typically passed through by proxy servers are checked in addition to
            // $_SERVER['REMOTE_ADDR']
            if ((bool)$proxyServer === true) {
                $serverParams = $request->getServerParams();
                foreach ($serverParams as $httpHeaderKey => $httpHeaderValue) {
                    $httpHeaderKey = preg_replace('/^HTTP_/', '', trim(strtoupper($httpHeaderKey)));
                    if (is_string($httpHeaderKey) && !empty($httpHeaderKey)
                        && in_array($httpHeaderKey, self::VALID_PROXY_HEADERS)
                        && is_string($httpHeaderValue) && !empty($httpHeaderValue)
                    ) {
                        // Allow for comma-separated list of multiple IP addresses,
                        // for example: "123.10.10.10, 123.10.10.20"
                        $candidates = explode(',', $httpHeaderValue);
                        $candidates = array_map('trim', $candidates);

                        foreach ($candidates as $candidate) {
                            if (GeneralUtility::validIPv4($candidate)
                            && GeneralUtility::cmpIP($candidate, $serverList) === true) {
                                return true;
                            }
                        }
                    }
                }
            }
        }
        return false;
    }

    /**
     * Returns comma-separated list of IP addresses, with hostnames resolved to IP addresses
     *
     * @access public
     * @param string $list Comma-separated list of IP addresses and hostnames (wildcard allowed)
     * @return string Comma-separated list of IP addresses (wildcard allowed)
     */
    public static function resolveHostnamesInList(string $list): string
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
                // Convert hostname to IP address: gethostbynamel() returns a list of IPv4
                // addresses to which the Internet host specified by hostname resolves.
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
