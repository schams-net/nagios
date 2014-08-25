.. include:: Images.txt

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)

.. _configuration:

Configuration
^^^^^^^^^^^^^

The following settings let you define which information should be passed to the Nagios® server. Depending on your system and TYPO3 version more or less of the following options are available. You can change the configuration via the “Extension Manager” (EM) as an Administrator backend user.

|illustration06|

You could also change the appropriate line in file “typo3conf/localhost.php” (but this is not the recommended way). If you are using TYPO3 6.0 or newer, do not edit the global configuration file “typo3conf/LocalConfiguration.php” but use the Extension Manager to configure your extensions.

Include TYPO3 version in output
"""""""""""""""""""""""""""""""

Enable or disable the version of the TYPO3 instance in output (for example: "TYPO3:version-4.5.0"). This might be useful to monitor if a specific version of TYPO3 becomes insecure and Nagios® should inform (warn) system administrators.

Include PHP version in output
"""""""""""""""""""""""""""""

Enable or disable the version of PHP in output (for example: "PHP:version-5.3.2"). This might be useful to monitor if a specific version of PHP becomes insecure, is unstable or is known as incompatible with TYPO3 and Nagios® should inform (warn) system administrators.

Include list of TYPO3 extensions and their versions in output
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

Enable or disable the extension key and version of all extensions in output (for example: "EXT:templavoila-1.5.0"). This might be useful to monitor if a specific version of a specific TYPO3 extension becomes insecure and Nagios® should inform (warn) system administrators.

Include loaded TYPO3 extensions only (not recommended)
""""""""""""""""""""""""""""""""""""""""""""""""""""""

TYPO3 has the concept of installed (imported) extensions and loaded extensions. An extension can be imported (e.g. by using the Extension Manager), which means, its files are copied to the extension directory (for example ”typo3conf/ext/”). This does not mean, the extension is really used – it is installed/imported only. In order to enable it and make it available in the system, it has to be **loaded**.

From a security perspective, unused TYPO3 extensions should not exist in the system (in the “document root” of the web server). Even though they are not enabled (and TYPO3 never executes their code), the files are in the file system and accessible/readable/executable by the web server (and by a remote call).

In TYPO3 versions 4.5.x and newer, all extensions (imported and not loaded as well as imported and loaded) are included in the output for Nagios®, if the extension list has been enabled (see option above). Optionally, you can exclude these not-loaded extensions from the list by this configuration. If you are unsure what to do, leave this setting un-ticked.

Please note, that including loaded extensions only is not recommended due to the fact that extensions with security vulnerabilities are causing a risk, even if they are not loaded and system administrators should monitor these extensions, too (or remove them from the system).

If the Nagios® extension runs in TYPO3 versions prior 4.5.x, the extension list can only include imported and loaded extensions (not loaded extensions do not appear in the list).

Include TYPO3 dependency warnings for extensions in output
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

Enable or disable the feature to include extensions in output, which have a dependency on a TYPO3 version and this does not match the TYPO3 version currently used. This feature is not supported in TYPO3 version 6.2.x. Extensions which do not have any dependencies set are not included in the output at all (this may change in the future).

Extension developers may define a dependency on TYPO3 between version x.y.z (min) and x.y.z (max) - or they may leave one or both of these values empty (undefined), which then becomes version 0.0.0 automatically. If the “max” version is undefined, this case is treated as “suspicious” and included in the output as well (in fact, version 0.0.0 is always less than the current TYPO3 version, so it is logical that an undefined max version is included anyway).

Please note: TYPO3 extensions uploaded to the official TYPO3 Extension Repository must have a minimum and maximum TYPO3 dependency set since 2013.

Include basic database details (amount of database tables) in output
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

Enable or disable basic database details (amount of database tables) in output (for example: "DBTABLES:62"). This might be useful to monitor because a MySQL server with less or more than an expected amount of database tables may be an indication of a problem.

Please note: Nagios® offers comprehensive MySQL database monitoring out-of-the-box. The TYPO3 Nagios® Extension does not pretend to replace this functionality. You may want to consider to configure Nagios® to monitor the MySQL server in a better way than the TYPO3 extension does. Please see the Nagios® documentation for further details: `http://www.nagios.org <http://www.nagios.org/>`_ .

Include basic database details (amount of DB processes) in output
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

Enable or disable basic database details (amount of DB processes) in output (for example: “DBPROCESSES:12"). This might be useful to monitor because a MySQL server with less or more than an expected amount of database tables may be an indication of a problem.

See note about MySQL database monitoring above.

Include status of deprecation log in output
"""""""""""""""""""""""""""""""""""""""""""

Enable or disable the status of the deprecation log setting in output. The deprecation log was introduced in TYPO3 version 4.3.0. Any usage of deprecated functions in TYPO3's PHP API or TypoScript is written to a deprecation log file. This is a nice feature but in large production environments the log file may grow rapidly (depending on amount of requests, extensions used and other circumstances). The TYPO3 Nagios® Extension enables system administrators to be warned if this feature is enabled, predominantly useful for production ("live") sites.

Please note: in newer TYPO3 versions the system extension "reports" checks the size of the log file, too, and warns if a specific threshold is exceeded.

Include status of donation notice popup in output
"""""""""""""""""""""""""""""""""""""""""""""""""

Enable or disable the status of the donation notice popup setting in output. This feature was introduced in TYPO3 version 4.4.0 and reminds users about the benefit they have with TYPO3. It shows a popup window in the TYPO3 backend to administrators which encourages them to donate to the TYPO3 Association, 90 days after the installation. The donation notice popup has been removed in TYPO3 version 4.5.1 again (and moved to the “About” section).

We believe this is/was a nice feature (we support the Association by being paying members) but under certain circumstances this popup is not desirable. The TYPO3 Nagios® Extension enables system administrators to be warned if this feature is enabled.

Please note: if you are interested in an ongoing and professional development of TYPO3 CMS, you should consider to support the community and the Association by a donation or a membership and not ignoring the donation notice popup.

Include the size of current disk usage (requires UNIX/Linux system)
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

Enable or disable to show the size of current disk usage used by the TYPO3 instance in output (for example: "DISKUSAGE:158042124", which is about 158 Mbytes). This feature requires that TYPO3 runs on a UNIX/Linux server (on Microsoft Windows systems no output or the value “not-supported” will be be shown).

Note: the value is not 100% reliable and depends on some conditions. First of all, the UNIX/Linux command “du” (disk usage) has to be installed, available and executable by the system user who runs the web server (e.g. “www-data”). Secondly, if the system user does not have access to all subdirectories of the TYPO3 root folder, not all data can be counted and the result may be inaccurate.

Include site name in output
"""""""""""""""""""""""""""

Enable or disable to show the site name of the TYPO3 instance in output. The site name can be configured in “typo3conf/localconf.php” (for example via the Install Tool), see: $TYPO3\_CONF\_VARS['SYS']['sitename']

Note: all characters except A to Z, digits 0 to 9, spaces, dots and dashes are filtered (removed from the string before output). The remaining string of characters is also be URL-encoded.

Include server name in output
"""""""""""""""""""""""""""""

Enable or disable to show the server name in output. The server name is the name of the server (e.g. virtual host) as set in the web server configuration - or the HTTP host name (sent by the client) if available.

Include current timestamp and timezone (server settings) in output
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

Enable or disable the current timestamp and timezone of the TYPO3 server. This might be useful to monitor in order to detect caching issues with the output or incorrect date/time settings of the TYPO3 server.

Comma-separated list of IP addresses of Nagios(R) servers
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""

This setting lets you limit the access to information about the TYPO3 instance. You can define one or more IP address(es) which are allowed to retrieve information about the TYPO3 instance. Separate two or more IP addresses by comma(s) and do not use spaces or any other character than 0 to 9 and the dot. The :ref:`next chapter <restrict-access-by-remote-ip-address>` shows an example.

Please see chapter :ref:`security-aspects` for further information.

Take IP address forwarded by proxy servers in HTTP header into account
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

Enable or disable the feature to take IP addresses forwarded by proxy servers in HTTP header into account, when checking, if the client is allowed to retrieve information about the TYPO3 instance. If you have not placed a proxy server in front of the TYPO3 instance or if you are in doubt, leave this checkbox unticked.

Please see chapters :ref:`typo3-behind-a-proxy` and the related :ref:`security aspects <security-aspects-typo3-behind-a-proxy-server>` for further information.

Suppress header line in output
""""""""""""""""""""""""""""""

The output of the extension shows a few lines with prefixed '#' as comments. Those comments include the extension name, extension version, etc. For example:

::

   # Nagios TYPO3 Monitoring Version 1.2.11 - http://schams.net/nagios 

I have been asked to suppress these lines and I implemented an option to allow administrators to deactivate them. Nevertheless, I am convinced that "security by obscurity" is definitely not the best approach and it should not make a difference to activate or deactivate this feature. If you are in doubt, leave this checkbox unticked.
