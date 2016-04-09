

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


Step-by-Step Installation
^^^^^^^^^^^^^^^^^^^^^^^^^

This section describes the installation steps in detail. Please note that this documentation was created on a TYPO3 version 6.1 instance. The visual appearance and some steps may differ depending on the TYPO3 version you are using and your individual configuration and site (for example: the "Extension Manager" looks  different in newer versions of TYPO3).

**Step 1:** Log in to the TYPO3 backend (BE) using a BE user with administrator privileges.

**Step 2:** Go to "ADMIN TOOLS -> Extension Manager" (left column).

**Step 3:** Ensure the list of available extensions (the "extension list") is up-to-date (retrieve a new list from the TYPO3 Extension Repository if required).

**Step 4:** Search for extension key "**nagios**" and click the “Import and Install” icon of the appropriate item in the list.

**Step 5:** Assuming the installation of the TYPO3 Nagios® extension was successful, go to the list of imported extensions and enable (*install*) it.
Newer versions of TYPO3 CMS automatically enable extensions and therefore, this step is not always required (it depends on the TYPO3 version used).

If your TYPO3 server can not communicate with the TYPO3 Extension Repository (e.g. due to a restrictive firewall setup), you can upload the T3X file to the server instead of importing the extension from the TER. This method may also be useful if you want to import/install a version that is not officially released yet. See "Download" page at `https://schams.net/nagios <https://schams.net/nagios>`_ for further details.

After the extension has been imported and installed/enabled, you should configure the output. Chapter :ref:`administration-and-configuration` describes the options in detail.

Please note that you also have to install and set up the counterpart: Nagios® server and Nagios® "check\_typo3" plugin, see: `https://schams.net/nagios <https://schams.net/nagios>`_
