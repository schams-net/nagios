# TYPO3 Behind a Proxy

In many setups, the Nagios® server that initiates the HTTP/HTTPS request to the TYPO3 instance, is seen by the TYPO3 instance is the “remote host”. In some environments, however, the TYPO3 instance is placed behind a proxy or caching server, load balancer, CDN solution, etc. In these cases (depending on the individual configuration), the “remote host” is the IP address of server that forwards the requests.

> You **should not** add the IP addresses of the proxy server to allow access to the TYPO3 extension “Nagios”. This would not only allow the Nagios® server but every client to access the output.

By enabling the security option “**TYPO3 behind proxy server**”, the TYPO3 extension “Nagios” also takes the following HTTP headers into account:

- `X-Real-IP`
- `X-Forwarded-For`

These headers are usually set by proxy servers and contain one or multiple IP addresses of the “real” client — which is the Nagios® server.

Please see chapter [Security Aspects](../../SecurityAspects/Index.md) for further security-related details about this configuration.

---

➤ Read next: [Security Aspects](../../SecurityAspects/Index.md).
