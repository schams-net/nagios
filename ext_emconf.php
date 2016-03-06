<?php

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Nagios TYPO3 Monitoring',
	'description' => 'Monitors TYPO3 instances and warns about insecure extensions, old TYPO3 versions, wrong PHP versions, etc. Requires a Nagios monitoring server. Detailed documentation, screenshots and more at: https://schams.net/nagios',
	'category' => 'misc',
	'version' => '2.0.0',
	'dependencies' => '',
	'module' => '',
	'state' => 'beta',
	'createDirs' => '',
	'clearcacheonload' => 0,
	'author' => 'Michael Schams (schams.net)',
	'author_email' => 'schams.net',
	'author_company' => 'https://schams.net',
	'constraints' => array(
		'depends' => array(
			'typo3' => '7.0.0-7.6.999',
			'php' => '5.5.0-5.6.999',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	)
);

?>
