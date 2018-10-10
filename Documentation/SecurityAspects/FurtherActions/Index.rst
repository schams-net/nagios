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

Further Actions
^^^^^^^^^^^^^^^

SSL/TLS
"""""""

The Nagios® plugin ``check_typo3.sh`` supports encrypted SSL/TLS requests (HTTPS). It is highly recommended to only allow HTTPS-requests.

HTTP Access Authentication
""""""""""""""""""""""""""

The Nagios® plugin ``check_typo3.sh`` also supports basic/digest HTTP access authentication (HTTP 401). This means, that the TYPO3 web server could be configured to require username/password authentication from the Nagios® server to access the system details provided by the TYPO3 extension (and to refuse requests with incorrect credentials).
