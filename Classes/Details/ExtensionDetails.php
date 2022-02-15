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
     * Extensionmanager ListUtility
     */
    private ListUtility $extensionListUtility;

    /**
     * Constructor
     */
    public function __construct(ListUtility $extensionListUtility)
    {
        $this->extensionListUtility = $extensionListUtility;
    }

    /**
     * Returns an array with available/installed extensions, system extensions excluded
     */
    public function getAvailableExtensions(bool $loadedExtensionsOnly = false): array
    {
        $installedExtensions = [];
        $availableExtensions = $this->extensionListUtility
            ->getAvailableAndInstalledExtensionsWithAdditionalInformation();
        foreach ($availableExtensions as $extensionKey => $extensionDetails) {
            if (array_key_exists('type', $extensionDetails)
                && array_key_exists('version', $extensionDetails)
                && $this->isValidExtensionKey($extensionKey)
                && strtolower($extensionDetails['type']) == 'local') {
                if (!$loadedExtensionsOnly
                    || ($loadedExtensionsOnly && ExtensionManagementUtility::isLoaded($extensionKey))
                ) {
                    // Fetch version through the ExtensionManagementUtility to ensure it's sanitized
                    $extensionVersion = $this->getExtensionVersion($extensionKey);
                    $extension = [$extensionKey, NagiosController::KEY_VERSION, $extensionVersion];
                    $installedExtensions[] = implode('-', $extension);
                }
            }
        }

        // Sort extension list by extension name
        sort($installedExtensions);
        return $installedExtensions;
    }

    /**
     * Returns an array with installed extensions (excludes extensions, which are available but not installed)
     */
    public function getInstalledExtensions(): array
    {
        return $this->getAvailableExtensions(true);
    }

    /**
     * Returns the version of a specific extension or (lower case) <branch> if version is "dev-<branch>"
     */
    public function getExtensionVersion(string $extensionKey): string
    {
        $version = ExtensionManagementUtility::getExtensionVersion($extensionKey);
        $version = preg_replace('/^v/', '', strtolower($version));
        if (preg_match('/^dev-/', $version)) {
            return substr($version, 4) ?: 'development';
        }
        return $version;
    }

    /**
     * Checks if syntax of extension key is valid
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
     */
    private function isValidExtensionVersion(string $version): bool
    {
        if (is_string($version) && preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $version)) {
            return true;
        }
        return false;
    }
}
