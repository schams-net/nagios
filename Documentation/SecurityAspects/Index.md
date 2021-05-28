# Security Aspects

It goes without saying that client/server communications using the HTTP protocol should be encrypted today. Therefore, your TYPO3 instance should enforce requests through SSL/TLS.

The Nagios® plugin `check_typo3.sh` also supports basic/digest HTTP access authentication (HTTP 401). This means that you can configure the TYPO3 web server to require a username/password authentication from the Nagios® server to access the system details genera by the TYPO3 extension “Nagios”.

The extension also features strong security measures out of the box. This includes [restricting access](RestrictAccessByRemoteIpAddress/Index.md) by remote IP address configuration and the fact that [proxy servers](Typo3BehindAProxyServer/Index.md) are supported.

➤ Read next: [Restrict Access by Remote IP Address](RestrictAccessByRemoteIpAddress/Index.md)


## Chapter Overview

- [Introduction](../Introduction/Index.md)
- [Installation and Setup](../InstallationAndSetup/Index.md)
- [Administration and Configuration](../AdministrationAndConfiguration/Index.md)
- **Security Aspects**
  - [Restrict Access by Remote IP Address](RestrictAccessByRemoteIpAddress/Index.md)
  - [TYPO3 Behind a Proxy Server](Typo3BehindAProxyServer/Index.md)
- [Extending Functionality](../ExtendingFunctionality/Index.md)
- [Troubleshooting](../Troubleshooting/Index.md)
- [Support](../Support/Index.md)
- [Changelog](../Changelog/Index.md)
