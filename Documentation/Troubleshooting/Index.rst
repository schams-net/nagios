

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


Troubleshooting
---------------

This section aims to help pinpointing and solving typical problems.

If you should stumble across a problem that could not being solved by following the instructions and is not covered in this section, feel free to contact me! I am always happy to update the documentation and/or update/fix the software in order to address issues.


The Nagios® server shows nothing: no error, no warning, no “OK”
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

If the Nagios® server shows nothing or just “TYPO3” (depending on the version of the Nagios® plugin you are using), but no error, no warning, no “OK” message, your configuration is incorrect. In most cases the Nagios® server does not get valid data from the TYPO3 server, so you should check what the Nagios® server “sees”. Run one of the following commands on the command line on your Nagios® server (replace "example.com" with the correct server name of your TYPO3 server) and check how the output looks like (see other troubleshooting points below).

If ``wget`` is installed on the server:

::

   wget --quiet --output-document - "http://example.com/?eID=nagios"


If ``curl`` is installed on the server:

::

   curl "http://example.com/?eID=nagios"


Alternatively, you could access the URL of your TYPO3 server with your browser but keep in mind that the IP address of your machine (e.g. your network at home) has to be allowed to retrieve information from the TYPO3 Nagios® plugin (see chapter :ref:`restrict-access-by-remote-ip-address`).


The output of the extension shows an “access denied” message
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

Ensure, you have added the correct IP address of the Nagios® server to the comma-separated list of allowed Nagios® servers in the extension configuration.

If you double checked the configuration and you still get the “access denied” message, check the web server's access log and find out which IP address tries to access the extension (look for requests such as ``“/?eID=nagios”``). Compare this with your configuration.

If the TYPO3 instance has been placed behind a proxy or caching server, load balancer, CDN solution, etc. the IP address accessing the server is unlikely the address of the Nagios® server. Follow the instructions in chapter :ref:`typo3-behind-a-proxy`.


The extension list shows loaded extensions only
"""""""""""""""""""""""""""""""""""""""""""""""

Make sure, the feature "Limit extension list to loaded extensions only" is **not ticked** in the extension configuration. See description and additional notes in chapter :ref:`configuration` for further details.


The “disk usage” value seems to be wrong
""""""""""""""""""""""""""""""""""""""""

If the system user (e.g. "www-data") does not have access to all subdirectories of the TYPO3 root folder, not all data can be counted and the result may be inaccurate. See description and additional notes in chapter :ref:`configuration` for further details.


The “disk usage” is not available on my Microsoft Windows server
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

The "disk usage" checks requires a UNIX/Linux-based system and the command ``du`` (disk usage) has to be installed. "disk usage" is not available on Microsoft Windows server. See description and additional notes in chapter :ref:`configuration` for further details.

Some characters are missing in the "site name" (e.g. German umlauts)
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

Special characters such as German umlauts, brackets, etc. are filtered. See description and additional notes in chapter :ref:`configuration` for further details.
