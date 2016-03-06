

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

The extension configuration of the TYPO3 Nagios® Extension contains an input field that holds a comma-separated list of IP addresses and/or fully qualified hostnames of all Nagios® servers which may retrieve information about the TYPO3 instance.

**Comma-separated list of IP addresses**

::

   127.0.0.1,192.168.1.123,123.45.67.89

**Comma-separated list of fully qualified hostnames**

::

   example.com,my-nagios-server.org


If the IP address or fully qualified hostname of the Nagios® server which initiates the requests to TYPO3 is not listed here, an **access denied** message appears (and the Nagios® server interprets this as a WARNING, CRITICAL or UNKNOWN condition, depending on its configuration):

::

   # Nagios TYPO3 Monitoring Version 2.0.0 – https://schams.net/nagios
   # ACCESS DENIED
   MESSAGE:access denied

Access to the output of the extension is also denied, if the input field has been left empty, or an insecure value such as ``*.*.*.*`` is used.
