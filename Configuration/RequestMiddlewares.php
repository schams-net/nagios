<?php
declare(strict_types = 1);

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

return [
    'frontend' => [
        'schams.net/nagios/core' => [
            'target' => \SchamsNet\Nagios\Middleware\NagiosMiddleware::class,
            'description' => 'TYPO3 Nagios Extension"',
            'before' => [
                'typo3/cms-frontend/eid'
            ],
        ]
    ]
];
