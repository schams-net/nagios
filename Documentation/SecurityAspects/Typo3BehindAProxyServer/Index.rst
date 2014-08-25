

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

.. _security-aspects-typo3-behind-a-proxy-server:

TYPO3 Behind a Proxy Server
^^^^^^^^^^^^^^^^^^^^^^^^^^^

As described before, the TYPO3 Nagios® Extension can be configured to take typical proxy HTTP headers into account. This decreases the level of security, because in theory, clients can add arbitrary headers in the request and pretend to be a valid Nagios® server, if...

a) the correct IP address of the Nagios® server is known,
b) the comma-separated list contains this IP address and
c) the client manages to bypass the proxy.

Although, it is unlikely that all of these conditions are met, additional strategies such as HTTP 401 access restrictions should be considered.

It is important to understand, that if the proxy server is on the **same** machine as the TYPO3 instance, do not add the localhost IP address (127.0.0.1) to the comma-separated list. This would enable everyone to access the output of the TYPO3 Nagios® extension (because every request hitting the TYPO3 instance is initiated by the proxy server on localhost, regardless the original initiator). It is also a good idea to exclude the output from being cached: assuming a legitimate client (e.g. the Nagios® server) accesses the data, the proxy server stores the response in its cache, and a second request from an unprivileged client executes the same request (shorty after), this request will possibly not reach the TYPO3 instance (and the IP address verification) but the proxy sends the data to the client from its cache.

Keep in mind: it is also a question of the classification of the data. As mentioned above, most of the information gathered by the extension are not sensitive information – at least if the TYPO3 instance is actively maintained and insecure extensions are updated.
