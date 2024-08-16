<?php

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

$EM_CONF[$_EXTKEY] = [
    'title' => 'Nagios TYPO3 Monitoring',
    'description' => 'Monitors TYPO3 instances and warns about insecure extensions, old TYPO3 versions,
        wrong PHP versions, etc. Requires a Nagios monitoring server.',
    'category' => 'misc',
    'version' => '5.0.0',
    'state' => 'beta',
    'author' => 'Michael Schams',
    'author_email' => 'schams.net',
    'author_company' => 'schams.net',
    'constraints' => [
        'depends' => [
            'php' => '8.2.0-8.2.99',
            'typo3' => '13.0.0-13.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
