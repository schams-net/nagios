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
Detailed documentation, screenshots and more at: http://schams.net/nagios',
	'category' => 'misc',
	'shy' => 0,
	'version' => '1.2.10',
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
	'author_company' => 'http://schams.net',
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
	'_md5_values_when_last_written' => 'a:22:{s:9:"ChangeLog";s:4:"2616";s:21:"ext_conf_template.txt";s:4:"e14c";s:12:"ext_icon.gif";s:4:"114d";s:17:"ext_localconf.php";s:4:"978f";s:14:"ext_tables.php";s:4:"6f76";s:16:"locallang_db.xml";s:4:"2883";s:17:"locallang_tca.xml";s:4:"7e7a";s:10:"README.txt";s:4:"51c9";s:27:"classes/class.tx_nagios.php";s:4:"a57a";s:34:"classes/class.tx_nagios_befunc.php";s:4:"23d4";s:31:"classes/class.tx_nagios_eid.php";s:4:"d7a5";s:37:"classes/class.tx_nagios_flexforms.php";s:4:"ac53";s:43:"classes/class.tx_nagios_utility_command.php";s:4:"3f37";s:14:"doc/manual.pdf";s:4:"7278";s:14:"doc/manual.sxw";s:4:"ef1c";s:27:"pi1/class.tx_nagios_pi1.php";s:4:"e055";s:17:"pi1/locallang.xml";s:4:"4d74";s:28:"res/flexforms/nagios_pi1.xml";s:4:"b494";s:21:"res/images/nagios.png";s:4:"7e4b";s:25:"res/images/schams-net.png";s:4:"4ce1";s:35:"res/nagios_monitoring/constants.txt";s:4:"8fb5";s:31:"res/nagios_monitoring/setup.txt";s:4:"38c1";}',
);

?>
