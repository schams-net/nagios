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

use TYPO3\CMS\Core\Information\Typo3Version;

/**
 * Class provides TYPO3 specific details
 */
class Typo3Details
{
    /**
     * Returns TYPO3 version as major.minor.release[-dev] value
     */
    public function getTypo3Version(): string
    {
        return (new Typo3Version())->getVersion();
    }
}
