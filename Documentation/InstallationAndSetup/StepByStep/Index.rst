

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

.. _step-by-step-installation:


Step-by-Step Installation
^^^^^^^^^^^^^^^^^^^^^^^^^

This section describes the installation steps in detail. Please note that this documentation was created with a TYPO3 version 7.6.0 instance. The visual appearance and some steps may differ slightly depending on the TYPO3 version you are using and your individual configuration and site.

**Step 1:** Log in to the TYPO3 backend (BE) using a BE user with administrator privileges.

**Step 2:** Go to "ADMIN TOOLS -> Extension Manager" (left column).

**Step 3:** Ensure the list of available extensions (the "extension list") is up-to-date (retrieve a new list from the TYPO3 Extension Repository if required).

**Step 4:** Search for extension key "**nagios**" and click the “Import and Install” icon of the appropriate item in the list.

**Step 5:** TYPO3 CMS automatically activates extensions by default. However this feature can be disabled. If the extension does not appear as *activated* in the "Installed Extensions" tab, activate it manually by clicking the icon left-hand-side.


If your TYPO3 server can not communicate with the TYPO3 Extension Repository (e.g. due to a restrictive firewall setup), you can upload the T3X file to the server instead of importing the extension from the TER. This method may also be useful if you want to import/install a version that is not officially released yet. See "Download" page at `schams.net <https://schams.net/nagios>`_ for further details.

After the extension has been imported and activated, you should configure which details it should output. Chapter :ref:`administration-and-configuration` describes the options in detail.

Please note that you also have to install and set up the counterpart: Nagios® server and Nagios® ``check_typo3.sh`` plugin, see chapter :ref:`nagios-server-plugin`.
