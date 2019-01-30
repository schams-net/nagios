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
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extensionmanager\Utility\ListUtility;
use SchamsNet\Nagios\Controller\NagiosController;

/**
 * Class contains methods for extension-related details, such as extension versions.
 */
class ExtensionDetails
{
    /**
     * Object Manager
     *
     * @access private
     * @var ObjectManager
     */
    private $objectManager = null;

    /**
     * Default constructor
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        /** @var $objectManager ObjectManager */
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
    }

    /**
     * Returns an array with available/installed extensions
     *
     * @access private
     * @param bool $loadedExtensionsOnly If set to "true", only loaded extensions are included (default: "false")
     * @return array List of available/installed extensions
     */
    public function getAvailableExtensions(bool $loadedExtensionsOnly = false): array
    {
        $installedExtensions = [];

        /** @var $extensionListUtility ListUtility */
        $extensionListUtility = $this->objectManager->get(ListUtility::class);

        $availableExtensions = $extensionListUtility->getAvailableAndInstalledExtensionsWithAdditionalInformation();
        foreach ($availableExtensions as $extensionKey => $extensionDetails) {
            if (array_key_exists('type', $extensionDetails)
                && array_key_exists('version', $extensionDetails)
                && $this->isValidExtensionKey($extensionKey) === true
                && $this->isValidExtensionVersion($extensionDetails['version']) === true) {
                if (strtolower($extensionDetails['type']) == 'local') {
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
        }

        // Sort extension list by extension name
        sort($installedExtensions);
        return $installedExtensions;
    }

    /**
     * Returns an array with installed extensions (excludes extensions, which are available but not installed)
     *
     * @access private
     * @return array List of installed extensions
     */
    public function getInstalledExtensions(): array
    {
        return $this->getAvailableExtensions(true);
    }

    /**
     * Returns the version of a specific extension
     *
     * @access private
     * @param string $extensionKey Extension key
     * @return string Extension version, e.g. "1.2.999"
     */
    public function getExtensionVersion(string $extensionKey): string
    {
        return ExtensionManagementUtility::getExtensionVersion($extensionKey);
    }

    /**
     * Checks if syntax of extension key is valid
     *
     * @access private
     * @param string $extensionKey Extension key
     * @return bool Returns true, if $extensionKey is a valid, false otherwise
     */
    private function isValidExtensionKey(string $extensionKey): bool
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
     * @param string $version Version such as "1.2.999"
     * @return bool Returns true, if $version is a valid extension version, false otherwise
     */
    private function isValidExtensionVersion(string $version): bool
    {
        if (is_string($version) && preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $version)) {
            return true;
        }
        return false;
    }
}
