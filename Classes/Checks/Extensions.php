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
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extensionmanager\Utility\ListUtility;
use SchamsNet\Nagios\Controller\NagiosController;

/**
 * Class contains methods for extension-related checks, such as extension versions.
 */
class Extensions
{
    /**
     * Returns an array with available/installed extensions
     *
     * @access private
     * @param object Object manager
     * @param bool Controls, if only loaded extensions should be included (true) or all extensions (false)
     * @return array List of available/installed extensions
     */
    public function getAvailableExtensions($objectManager, $loadedExtensionsOnly = false)
    {
        $installedExtensions = [];

        /** @var $objectManager TYPO3\CMS\Extbase\Object\ObjectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var $extensionListUtility TYPO3\CMS\Extensionmanager\Utility\ListUtility */
        $extensionListUtility = $objectManager->get(ListUtility::class);

        $availableExtensions = $extensionListUtility->getAvailableAndInstalledExtensionsWithAdditionalInformation();
        foreach ($availableExtensions as $extensionKey => $extensionDetails) {
            if (array_key_exists('type', $extensionDetails)
                && array_key_exists('version', $extensionDetails)
                && $this->isValidExtensionKey($extensionKey) === true
                && $this->isValidExtensionVersion($extensionDetails['version']) === true) {
                if ($loadedExtensionsOnly === false
                    || ($loadedExtensionsOnly === true
                        && ExtensionManagementUtility::isLoaded($extensionKey) === true
                    )
                ) {
                    $extension = [$extensionKey, NagiosController::KEY_VERSION, $extensionDetails['version']];
                    $installedExtensions[] = implode('-', $extension);
                }
            }
        }

        // sort extension list by extension name
        sort($installedExtensions);
        return $installedExtensions;
    }

    /**
     * Returns an array with installed extensions (excludes extensions, which are available but not installed)
     *
     * @access private
     * @param object Object manager
     * @return array List of installed extensions
     */
    public function getInstalledExtensions($objectManager)
    {
        return $this->getAvailableExtensions($objectManager, true);
    }

    /**
     * Returns the version of a specific extension
     *
     * @access private
     * @param string Extension key
     * @return string Extension version, e.g. "1.2.999"
     */
    public function getExtensionVersion($extensionKey)
    {
        return ExtensionManagementUtility::getExtensionVersion($extensionKey);
    }

    /**
     * Checks if syntax of extension key is valid
     *
     * @access private
     * @param string Extension key
     * @return bool Returns true, if $extensionKey is a valid, false otherwise
     */
    private function isValidExtensionKey($extensionKey)
    {
        if (isset($extensionKey) && is_string($extensionKey) && preg_match('/^[a-z0-9_]{3,}$/', $extensionKey)) {
            return true;
        }
        return false;
    }

    /**
     * Checks if syntax of extension version is valid
     *
     * @access private
     * @param string Version such as "1.2.999"
     * @return bool Returns true, if $version is a valid extension version, false otherwise
     */
    private function isValidExtensionVersion($version = null)
    {
        if (is_string($version) && preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $version)) {
            return true;
        }
        return false;
    }
}
