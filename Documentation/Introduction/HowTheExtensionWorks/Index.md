# How the Extension Works

## General Overview

The TYPO3 extension “Nagios” gathers information about the TYPO3 system and exposes the data for a Nagios® server to access. The Nagios® server parses and analyses the data and acts appropriately according to its configuration.
<!-- Both parts (the Nagios® server and the TYPO3 extension) build a system that enables system administrators to monitor a large number of TYPO3 instances and to notify administrators about a suspicious condition of one or more TYPO3 instances. -->

![](../../Images/illustration01.png)

The Nagios® server (left) contains the “Check TYPO3” plugin which communicates via HTTP/HTTPS with one or more TYPO3 servers. The TYPO3 server (right) contains the TYPO3 extension “Nagios”. A typical use case for Nagios® and the TYPO3 extension is to monitor a server farm with dozens of TYPO3 servers and to make sure that the infrastructure is fully functional, up-to-date, and secure.

The focus of this documentation is on the TYPO3 extension. The counterpart (the Nagios® server and its “Check TYPO3” plugin) is briefly described in chapter [Nagios Server Plugin](../../InstallationAndSetup/NagiosServerPlugin/Index.md).


## Detailed Overview

Nagios® is the de-facto standard of open-source network and server monitoring. It is a powerful monitoring system that enables system operators to identify and resolve IT infrastructure problems before they affect critical business processes. A professional hosting infrastructure includes one or more monitoring instances in order to check if the network, the servers, and the services are all up and running. A Nagios® server monitors these components and notifies system administrators if a suspicious condition or a fatal error (e.g. services respond too slow, servers are not reachable) occurs.

Nagios® provides a comprehensive set of checks off-the-shelf including PING (ICMP), disk space monitoring, server load monitoring, memory consumption monitoring, etc. (on a server level) but also SMTP, SSH, HTTP/HTTPS response, etc. (on a service/application level). Besides these basic checks, Nagios® allows system administrators to implement and configure their own checks.

The TYPO3 extension “Nagios” in combination with the “Check TYPO3” plugin for Nagios® (`check_typo3.sh`) lets system administrators gather details about a TYPO3 site. In a practical sense, this means that system managers can be warned if a TYPO3 server runs with a specific (e.g. outdated) TYPO3 or PHP version, or if TYPO3's development application context is enabled on a production system.

According to its developers, the Nagios® server is optimized for running on a Linux/UNIX server. The software is able to monitor all kinds of servers, services, and network devices (e.g. Windows/Mac/Linux/UNIX machines, Netware servers, routers/switches, network printers, and publicly available services such as HTTP, FTP, SSH, etc.).

Read more about Nagios® and monitoring strategies at the following sites:

- The official [Nagios® web site](http://www.nagios.org/).
- Nagios® on [Wikipedia](http://en.wikipedia.org/wiki/Nagios).
- Overview of [Network Monitoring Systems](https://en.wikipedia.org/wiki/Comparison_of_network_monitoring_systems).

As pointed out above, the Nagios® server is out of scope of this documentation.

---

➤ Read next: [Technical Concept](../TechnicalConcept/Index.md).
