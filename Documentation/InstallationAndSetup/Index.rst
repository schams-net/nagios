

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


Installation and Setup
----------------------

Installing the extension is pretty easy and straight forward. In short, you only need to import/install the Nagios® Extension to your TYPO3 instance, configure the features you want to monitor and allow the Nagios server to access the data (by providing the server's IP address). Chapter :ref:`administration-and-configuration` describes the settings and customization in detail.

In older versions of this extensions (prior version 1.2.0), you had to create a new page (hidden in menu) and add the Nagios® Extension to this page. This is not longer required and has been discontinued. From version 1.2.6 on, the TYPO3 Nagios® Extension does not support this method any more.

If you update the extension from an old version to the latest version, please refer to chapter :ref:`update` below.

.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   Requirements/Index
   Step-by-stepInstallation/Index
   Update/Index
