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


Who is Who in the Jungle?
^^^^^^^^^^^^^^^^^^^^^^^^^

It is easy to lose track of the terminology used in this documentation and the following image aims to clarify the components involved in the monitoring system (simplified).

|illustration01|

The Nagios® server (left) contains the Nagios® TYPO3 plugin which communicates via HTTP (see next section) with one or more TYPO3 servers. The other side - the TYPO3 server (right) - contains the TYPO3 Nagios® Extension (which is described in this document).
