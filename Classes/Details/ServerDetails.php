<?php
declare(strict_types=1);
namespace SchamsNet\Nagios\Details;

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

/**
 * Class contains methods for retrieving server-related data, such as PHP version.
 * Server-related configurations usually require system administrator privileges
 * and can not be changed/adjusted by a TYPO3 integrator.
 */
class ServerDetails
{
    /**
     * Returns PHP version as major-minor-release value (values such as "5.6.7-2ubuntu5.6" get cleaned up)
     * Example: 5.6.7
     *
     * @access public
     * @return string Cleaned/simplified PHP version
     */
    public function getPhpVersion(): string
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
     * @return string Server name, host name or "not-supported" otherwise
     */
    public function getServerName(): string
    {
        $serverVariables = ['SERVER_NAME', 'TYPO3_HOST_ONLY', 'HTTP_HOST'];
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
     * Example: 1548302813-UTC
     *
     * @access public
     * @return string
     */
    public function getTimeStamp(): string
    {
        return date('U-T');
    }
}
