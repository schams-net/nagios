

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

.. _restrict-access-by-remote-ip-address:

Restrict Access by Remote IP Address
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The extension configuration of the TYPO3 Nagios® Extension contains an input field that holds a comma-separated list of IP addresses of all Nagios® servers which may retrieve information about the TYPO3 instance.

**Comma-separated list of IP addresses of Nagios(R) servers**

::

   127.0.0.1,192.168.1.123,123.45.67.89

If the IP address of the Nagios® server which initiates the requests to TYPO3 is not listed here, an "access denied" message appears (and the Nagios® server interprets this as a WARNING, CRITICAL or UNKNOWN condition, depending on its configuration):

::

   # Nagios TYPO3 Monitoring Version 1.2.12 – https://schams.net/nagios
   #
   # ACCESS DENIED 
   # Remote server is not allowed to retrieve information about this TYPO3 server. 
   # If you think this is an error, check the settings of TYPO3 Nagios(R) Extension
   MESSAGE:access denied

If you leave the input field empty, a warning appears every time an administrator user logs into the backend of TYPO3 (“misconfigured extension detected”).

Please note: access restrictions based on IP addresses are not 100% secure (IP addresses can be spoofed).
