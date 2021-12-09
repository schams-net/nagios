# Security Options

**Option:**
: URI

**Description:**
: The URI to access the details of the TYPO3 instance. Allowed characters are only letters, numbers, and the forward-slash.

**Default:**
: `/nagios`

---

**Option:**
: Suppress Header

**Description:**
: By default, the output of the extension starts with a few comment lines:
: `# Nagios TYPO3 Monitoring Version 3.0.1 – https://schams.net/nagios`
: You can supress the output of these header line(s) by enabling the security option “**Suppress Header**”.

**Default:**
: **☐** disabled

---

**Option:**
: Nagios(R) servers

**Description:**
: This setting lets you limit the access to the TYPO3 extension “Nagios”. You can define one or multiple IPv4 and/or IPv6 addresses. Alternatively, you can use fully qualified hostnames which are allowed to retrieve information from the TYPO3 instance. Separate two or more values by comma(s). The [next chapter](../../../SecurityAspects/RestrictAccessByRemoteIpAddress/Index.md) shows an example. Please see chapter [security aspects](../../../SecurityAspects/Index.md) for further information.

**Default:**
: `127.0.0.1`

---

**Option:**
: TYPO3 behind proxy server

**Description:**
: Enable or disable the feature to take IP addresses forwarded by proxy servers in the HTTP header into account when checking, if a client is allowed to access the TYPO3 instance. If the TYPO3 instance is not behind a proxy server, leave this security option disabled. Read the chapter [TYPO3 Behind a Proxy](../../Typo3BehindAProxy/Index.md) for further details.

**Default:**
: **☐** disabled

---

➤ Read next: [TYPO3 Behind a Proxy](../../Typo3BehindAProxy/Index.md) 
