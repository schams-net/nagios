# Administration and Configuration

Monitoring a TYPO3 instance is a typical responsibility of a system manager or administrator.

It is important to understand that you control the “features” (the details about the TYPO3 system) at the TYPO3 side. The Nagios® server (more precisely the “Check TYPO3” plugin) reads, parses, and *interprets* the information only.

This means that if a specific information is disabled in the TYPO3 extension, it is not available in the output and the Nagios® server can not access it. Therefore, Nagios® will not react if there is a problem (e.g. an outdated TYPO3 or PHP version). This also means that the data is analyzed by the Nagios® server  and not the TYPO3 instance.

The TYPO3 extension compiles and outputs the data without any assessment if a problem exists.

Open the [extension configuration](Configuration/Index.md) in the TYPO3 backend. This lets you configure the [features](Configuration/Features/Index.md) and [security options](Configuration/Security/Index.md).

If you run your TYPO3 instance behind a proxy server, for example a load balancer, a content delivery network (CDN), etc. you likely want to read the [use-case description](Typo3BehindAProxy/Index.md).

➤ Read next: [Configuration](Configuration/Index.md)


## Chapter Overview

- [Introduction](../Introduction/Index.md)
- [Installation and Setup](../InstallationAndSetup/Index.md)
- **Administration and Configuration**
  - [Extension Configuration](Configuration/Index.md)
  - [Configuration of Features](Configuration/Features/Index.md)
  - [Security Options](Configuration/Security/Index.md)
  - [TYPO3 Behind a Proxy](Typo3BehindAProxy/Index.md)
- [Security Aspects](../SecurityAspects/Index.md)
- [Extending Functionality](../ExtendingFunctionality/Index.md)
- [Troubleshooting](../Troubleshooting/Index.md)
- [Support](../Support/Index.md)
- [Changelog](../Changelog/Index.md)
