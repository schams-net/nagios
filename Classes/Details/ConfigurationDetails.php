<?php
declare(strict_types = 1);
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
 * Class contains methods for configuration-related details.
 * These details are usually adjusted by an administrator or TYPO3 integrator.
 * They are not server, or system, or TYPO3-related.
 */
class ConfigurationDetails
{
    /**
     * Returns the current application context.
     * TYPO3 CMS provides three built-in contexts: Production, Development and Testing.
     * https://docs.typo3.org/typo3cms/CoreApiReference/ApiOverview/Bootstrapping/Index.html
     *
     * The context can be set by using the environment variable TYPO3_CONTEXT.
     * For example in Apache: SetEnv TYPO3_CONTEXT Development
     *
     * @access public
     * @return string Application context as configured
     */
    public function getApplicationContext(): string
    {
        /* use TYPO3\CMS\Core\Core\ApplicationContext; */
        return (string)GeneralUtility::getApplicationContext();
    }

    /**
     * Returns the site name as configured in typo3conf/LocalConfiguration.php
     * For example: "My TYPO3 Website"
     *
     * @access public
     * @return string Site name
     */
    public function getSiteName(): string
    {
        return $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'];
    }
}
