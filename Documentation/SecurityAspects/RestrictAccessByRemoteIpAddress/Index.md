# Restrict Access by Remote IP Address

The [extension configuration](../../AdministrationAndConfiguration/Configuration/Index.md) features an input field that holds a comma-separated list of IPv4/IPv6 addresses and/or fully qualified hostnames of all Nagios® servers which are allowed to access the output of the TYPO3 extension “Nagios”.

Comma-separated list of IP addresses:

```text
127.0.0.1,192.168.1.123,123.45.67.89
```

Comma-separated list of fully qualified hostnames:

```text
example.com,my-nagios-server.org
```

If the IP address or fully qualified hostname of the Nagios® server that initiated the request is not included in the comma-separated list, an **access denied** message appears:

```text
# Nagios TYPO3 Monitoring Version 3.0.1 – https://schams.net/nagios
# ACCESS DENIED
MESSAGE:access denied
```

Access to the output of the  TYPO3 extension “Nagios” is also denied, if the input field is empty or contains an insecure value such as `*.*.*.*`.

---

➤ Read next: [TYPO3 Behind a Proxy Server](../Typo3BehindAProxyServer/Index.md).
