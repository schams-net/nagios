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

Installing the extension is pretty easy and straight forward: you only need to import/install the Nagios® extension to your TYPO3 instance, configure the features you want to monitor and allow the Nagios server to access the data (by providing the server's IP address or fully qualified host name). Chapter :ref:`administration-and-configuration` describes the settings and customization in detail.

Please check the :ref:`system_requirements` to make sure, the extension works in your TYPO3 instance and on your server.

If you update the extension from an older version to the latest version, refer to chapter :ref:`update`.


.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   SystemRequirements/Index
   StepByStep/Index
   Update/Index
   NagiosServerPlugin/Index
