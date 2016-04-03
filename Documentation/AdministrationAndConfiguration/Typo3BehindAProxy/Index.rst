

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

.. _typo3-behind-a-proxy:

TYPO3 Behind a Proxy
^^^^^^^^^^^^^^^^^^^^

In a server setup where the TYPO3 instance has been placed behind a proxy or caching server, load balancer, CDN solution, etc. (we will use the terminology "proxy server" from now on) the IP address of the client that initiates the HTTP request (and tries to retrieve information about the TYPO3 instance) is not the Nagios® server. Therefore, the comma-separated list of IP addresses, which are allowed to retrieve information about the TYPO3 instance, possibly does not include the "correct" IP address and the TYPO3 Nagios® extension would always deny access.

You can check the web server's access log to find out what the correct IP address is, that accesses the extension (search for requests such as ``/?eID=nagios``).

If the proxy server is on a  **different** machine, add this IP address to the list. If more than one proxy server is used, add every IP address (comma-separated) to the list.

If the proxy server is on the  **same** machine as the TYPO3 instance or if the IP address of the proxy server is not known and not predictable, you should consider enabling the feature "take IP address forwarded by proxy servers into account". Typical examples for such a scenario are the "Elastic Load Balancing" and "CloudFront" services by Amazon Web Services (AWS). The TYPO3 Nagios® Extension can deal with this setup, too, if the proxy server passes through the IP address of the "real initiator" (the Nagios® server) in the HTTP header.

If the TYPO3 Nagios® Extension should take these headers into account when checking, if the client is allowed to retrieve information about the TYPO3 instance, the feature must be explicitly enabled in the extension configuration, see chapter :ref:`configuration`.

Currently supported HTTP headers are:

- ``X-Real-IP``

- ``X-Forwarded-For``

However enabling this feature comes with a downside, see chapter :ref:`security-aspects`.
