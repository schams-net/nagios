

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

.. _update:

Update
^^^^^^

Update from version 1.0.x or version 1.2.x
""""""""""""""""""""""""""""""""""""""""""

Due to the fact that version 2.0.x is a re-development of the extension from scratch, which requires at least TYPO3 CMS version 7.6.x, and version 1.0.x and 1.2.x of the extension is incompatible with this TYPO3 CMS version, it is very unlikely that someone updates from 1.0.x to 2.0.x or 1.2.x to 2.0.x. The process will include an update of TYPO3 CMS, too.

As a consequence, the easiest is to **inactivate and delete** the old version of the extension, update TYPO3 CMS and install the new version 2.0.x via the Extension Manager including the steps described in chapter :ref:`step-by-step-installation`. 

Please note that you possibly need to adjust the arguments of the check script on the Nagios® server and remove ``pid <pageid>`` (or ``--pageid <pageid>``) and replace it with ``--resource /?eID=nagios``. In newer versions of the "check\_typo3.sh" plugin for Nagios®, even the ``--resource`` parameter is not required. A typical line in the Nagios® configuration file looks like:

::

   check_command           check_typo3!--hostname example.com


Removed and Added Features
""""""""""""""""""""""""""

Compared to older versions of the extension, the following features have been **removed** in version 2.0.0:

- TYPO3 dependency warnings for extensions
- basic database details (number of database tables and number of DB processes)
- status of donation notice popup


The following feature has been **added** in version 2.0.0:

- application context
