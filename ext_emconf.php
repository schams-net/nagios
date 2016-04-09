<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "nagios".
 *
 * Auto generated 04-06-2013 23:23
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Nagios TYPO3 Monitoring',
	'description' => 'Monitors TYPO3 instances and warns about insecure extensions, old TYPO3 versions, wrong PHP versions, etc. Requires a Nagios monitoring server.
Detailed documentation, screenshots and more at: https://schams.net/nagios',
	'category' => 'misc',
	'shy' => 0,
	'version' => '1.2.12',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Michael Schams (schams.net)',
	'author_email' => 'schams.net',
	'author_company' => 'https://schams.net',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.5.0-6.2.999',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);

?>
