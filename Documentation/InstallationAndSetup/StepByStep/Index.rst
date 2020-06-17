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

This section describes the installation steps in detail. The labels and exact steps may slightly vary, depending on the TYPO3 version you are using and your individual site configuration.

Extension Manager
"""""""""""""""""

If your TYPO3 instance has been installed using the *traditional* method, you can use the Extension Manager to download and install the TYPO3 extension.

**Step 1:** Log in to the TYPO3 backend (BE) using a BE user with administrator privileges.

**Step 2:** Go to "ADMIN TOOLS -> Extensions" (left column).

**Step 3:** Ensure the list of available extensions (the "extension list") is up-to-date (retrieve a new list from the `TYPO3 Extension Repository <https://extensions.typo3.org/>`_ if required).

**Step 4:** Search for extension key "**nagios**" and click the “Import and Install” icon of the appropriate item in the list.

**Step 5:** TYPO3 automatically activates extensions. However, this feature can be disabled in some versions of TYPO3. If the extension does not appear as *activated* in the "Installed Extensions" tab, activate it manually by clicking the icon left-hand-side.


If your TYPO3 server can not communicate with the `TYPO3 Extension Repository <https://extensions.typo3.org/>`_ (e.g. due to a restrictive firewall setup), you can upload the ZIP file to the server instead. This method may also be useful if you want to import/install a version that is not officially released yet. The ZIP file of every versions of the extension can be downloaded from `TYPO3 Extension Repository <https://extensions.typo3.org/extension/nagios/>`_

PHP Composer
""""""""""""

This Nagios® TYPO3 extension is also available as a `Composer <https://getcomposer.org/>`_ package. This makes the installation and updates super-easy. If the TYPO3 instance has been installed using Composer, the default method of adding (installing) the extension is the following command:

::

   composer require schams-net/nagios

Composer resolves dependencies automatically and downloads the best possible version. You can also specify the desired extension version directly. The following command installs the latest 2.1.x version (if possible) and ensures, it remains at the 2.1-version constraint when you run a composer update in the future.

::

   composer require schams-net/nagios ^2.1

Once the extension has been downloaded and added to your TYPO3 instance, you possibly need to activate it. This can be done in the Extension Manager.


Next Steps
""""""""""

As soon as the extension has been activated, you should configure which details should be output. Chapter :ref:`administration-and-configuration` describes the options in detail.

Please note that you also have to install and set up the counterpart: Nagios® server and Nagios® ``check_typo3.sh`` plugin, see chapter :ref:`nagios-server-plugin`.
