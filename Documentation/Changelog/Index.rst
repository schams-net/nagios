

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


ChangeLog
---------

.. tabularcolumns:: |r|p{13.7cm}|

=======  ==========  =======================================================================
Version  Date        Changes
=======  ==========  =======================================================================
0.0.1    2010-09-19  - Initial version (alpha version - not published)
0.1.0    2010-10-04  - First test version (beta version - not published)
1.0.0    2011-04-01  - Officially released as a stable version (published at the `TYPO3 Extension Repository <http://typo3.org/extensions/repository/>`_ "TER")
1.0.1    2011-10-07  - Implementation of eID method and other significant code changes (beta version - not published)
1.1.0    2011-11-01  - Officially released as a stable version (accidentally published as version 1.2.0)
1.2.1    2011-11-01  - Corrupted version information fixed (published as version 1.2.1)
1.2.2    2011-12-01  - Minor code optimizations and small bug fixes
                     - Compatibility with TYPO3 version 4.1.x and TYPO3 version 4.2.x implemented
                     - Documentation updated
                     - Officially released as a beta version (published at the `TYPO3 Extension Repository <http://typo3.org/extensions/repository/>`_ "TER")
1.2.3    2012-01-05  - New check “disk usage” implemented
                     - Option to include site name and server name implemented
                     - Documentation updated (new screenshots generated, and more)
                     - Officially released as a stable version (published at the `TYPO3 Extension Repository <http://typo3.org/extensions/repository/>`_ "TER")
1.2.4    2012-05-01  - New check “extension dependency” (TYPO3 min/max versions) implemented
                     - Display Nagios plugin version and IP address of Nagios server implemented
                     - Deprecated use of the FE plugin generates warning message
                     - Some internal code optimizations implemented (e.g. avoid entries in TYPO3's deprecation log but ensure compatibility with older TYPO3 versions, and other optimizations)
                     - Documentation updated
                     - Officially released as a stable version (published at the `TYPO3 Extension Repository <http://typo3.org/extensions/repository/>`_ "TER")
1.2.5    2012-11-06  - Installed (and possibly not loaded) extensions included in output
                     - Documentation updated
                     - Officially released as a stable version (published at the `TYPO3 Extension Repository <http://typo3.org/extensions/repository/>`_ "TER")
1.2.6    2012-12-17  - Support for proxy/caching/load balancing server added
                     - Usage of the extension as a FE plugin discontinued and partly removed
                     - Documentation updated
                     - Officially released as a stable version (published at the `TYPO3 Extension Repository <http://typo3.org/extensions/repository/>`_ "TER")
1.2.7    2013-01-09  - Access verification when checking for HTTP proxy headers fixed
                     - Documentation updated
                     - Officially released as a stable version (published at the `TYPO3 Extension Repository <http://typo3.org/extensions/repository/>`_ "TER")
1.2.8    2013-03-13  - PHP warnings in sys log (t3lib/class.t3lib\_iconworks.php) fixed
                     - Officially released as a stable version (published at the `TYPO3 Extension Repository <http://typo3.org/extensions/repository/>`_ "TER")
1.2.9    2013-05-31  - Tested with TYPO3 CMS version 6.1 and compatibility statement updated
                     - Documentation updated
                     - Officially released as a stable version (published at the `TYPO3 Extension Repository <http://typo3.org/extensions/repository/>`_ "TER")
1.2.10   2014-03-22  - Support of TYPO3 CMS version 6.2.x added
                     - Tested with TYPO3 CMS version 6.2.0RC1 and compatibility statement updated
                     - Documentation updated
                     - Officially released as a stable version (published at the `TYPO3 Extension Repository <http://typo3.org/extensions/repository/>`_ "TER")
1.2.11   2014-07-11  - Documentation updated and converted into ReST format
                     - LICENSE.txt file added (GPLv2)
                     - Header comments simplified/updated
                     - Deprecation warning eliminated: EidUtility::connectDB()
                     - Officially released as a stable version (published at the `TYPO3 Extension Repository <http://typo3.org/extensions/repository/>`_ "TER")
1.2.12   2016-04-09  - Documentation updated
                     - Code clean up
                     - TYPO3 CMS compatibility information updated
                     - Transfer source code to GitHub
                     - Allow hostnames in list of allowed Nagios servers
                     - Allow for multiple IP addresses sent by proxies/caches/load balancers
                     - Officially released as a stable version (published at the `TYPO3 Extension Repository <http://typo3.org/extensions/repository/>`_ "TER")
