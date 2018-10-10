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

In many setups, the Nagios® server that initiates the HTTP/HTTPS request to the TYPO3 instance, is seen by the TYPO3 instance is the "remote host". Therefore the IP addresses can easily be checked against the configuration as described in section :ref:`system_requirements`.

However, in an infrastructure setup where the TYPO3 instance has been placed behind a proxy or caching server, load balancer, CDN solution, etc. (we will use the terminology "proxy server" from now on) the IP address of the Nagios® server is typically *masqueraded*. In these cases, the proxy server is the remote host and the comma-separated list of IP addresses, which are allowed to retrieve information about the TYPO3 instance, possibly does not include the "correct" IP address the access is denied.

Adding the IP addresses of all proxy servers to the list of allowed hosts is a bad idea, because this would allow **every** host to access the system details provided by the TYPO3 extension, not the Nagios® server only.

By enabling the feature "take IP address forwarded by proxy servers into account", the following HTTP headers are included in the IP check:

- ``X-Real-IP``
- ``X-Forwarded-For``

These headers are usually set by proxy servers and contain one or multiple IP addresses of the "real" client. In our case, this is the Nagios® server.

However enabling this feature introduces another risk, see chapter :ref:`security-aspects`.
