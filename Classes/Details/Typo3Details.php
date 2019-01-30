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

/**
 * Class provides TYPO3 specific details
 */
class Typo3Details
{
    /**
     * Returns TYPO3 version as major.minor.release[-dev] value
     *
     * @access public
     * @return string TYPO3 version
     */
    public function getTypo3Version(): string
    {
        return TYPO3_version;
    }
}
