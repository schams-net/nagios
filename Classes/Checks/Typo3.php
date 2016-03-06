<?php
namespace SchamsNet\Nagios\Checks;
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

/**
 * [...]
 */
class Typo3
{

	/**
	 * Returns TYPO3 version as major.minor.release[-dev] value
	 *
	 * @access public
	 * @return string
	 */
    public function getTypo3Version() {
		return TYPO3_version;
    }
}
