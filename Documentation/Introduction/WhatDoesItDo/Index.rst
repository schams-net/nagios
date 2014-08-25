

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


What Does It Do?
^^^^^^^^^^^^^^^^

The TYPO3 Nagios® Extension gathers some information about the TYPO3 CMS system and passes these details on to a Nagios® server. The Nagios® server parses and analyses the data and may react appropriately according to its configuration. Both parts (the Nagios® server and the TYPO3 extension) build a system that enables system administrators to monitor a large number of TYPO3 CMS servers and notifies administrators about a suspicious condition of one or more TYPO3 instances.

A typical use case for Nagios® and this TYPO3 CMS extension is to monitor a server farm with dozens of TYPO3 servers and to ensure the infrastructure is up-to-date and in a secure and "healthy" condition.

It is important to understand that this documentation covers the TYPO3 extension only. The counterpart (the Nagios® server and the "check\_typo3" plugin) is not part of this documentation. You find further installation and configuration instruction on the web site at `http://schams.net/nagios <http://schams.net/nagios>`_ .