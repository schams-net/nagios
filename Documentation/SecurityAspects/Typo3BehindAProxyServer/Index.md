# TYPO3 Behind a Proxy Server

## HTTP Header Injection

As [described before](../../AdministrationAndConfiguration/Typo3BehindAProxy/Index.md), you can configure the TYPO3 extension “Nagios” to take HTTP headers into account that proxy servers typically send. However, this possibly weakens the security of your environment. Clients can *inject* arbitrary headers in the request and therefore pretend to be a valid Nagios® server. A few conditions must be met to successfully draft such an attack:

1. The correct IP addresses or hostnames of the Nagios® server must be known.
2. The comma-separated list must contain this IP address or hostname.
3. The client has to be able to bypass the proxy.
4. Proxy servers or other network components must allow HTTP header injections.

If these conditions are met on your infrastructure, I highly recommend to consider additional authentication strategies such as a HTTP 401 access restriction.


## Local Proxy Servers

If the proxy server runs on the **same machine** as the TYPO3 instance, do not add the localhost IP address (`127.0.0.1`) to the comma-separated list. This would enable everyone to access the output of the TYPO3 extension “Nagios”.


## Prevent Caching

Make sure that proxy server(s) do not cache the output of the TYPO3 extension “Nagios”. This would cause the proxy server to leak the data if a response to a legitimate request is stored in the cache.

---

➤ Read next: [Extending Functionality](../../ExtendingFunctionality/Index.md).
