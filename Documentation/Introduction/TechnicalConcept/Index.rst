.. include:: Images.txt

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


Technical Concept
^^^^^^^^^^^^^^^^^

The following illustration shows the technical concept of a typical monitoring system.

|illustration02|

Simplified, the Nagios®Core executes its plugin "check\_typo3.sh" in a configured time interval. The plugin reads the configuration ("check\_typo3.cfg") and requests the TYPO3 server via HTTP (TCP). The request includes a unique eID (eID=nagios) and (optionally) some further parameters.

TYPO3 receives the request and executes the Nagios® Extension which checks if the requesting server is allowed to access the data. If so, the extension gathers some information about the TYPO3 instance (all information is configurable in the TYPO3 backend) and shows it in a propriety format (text/plain).

The Nagios® plugin reads the response, analyzes the data and checks the information against its configuration. According to the configuration, one of the following states is reported back to the Nagios® Core (in addition to a meaningful condition description):

- OK

- WARNING

- CRITICAL

- UNKNOWN

Finally, the Nagios® Core reacts appropriately to this states and may notify system administrators (for example by sending an email or a SMS text message).

Please note that the TYPO3 Nagios® Extension is only **one** component of the system.
