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

Due to the fact that version 2.0.x is a re-development of the extension from scratch, which requires at least TYPO3 version 7.6.x, and version 1.0.x and 1.2.x of the extension is incompatible with this TYPO3 version, it is very unlikely that someone updates from 1.0.x to 2.0.x or 1.2.x to 2.0.x. The process will include an update of TYPO3, too.

As a consequence, the easiest is to **inactivate and delete** the old version of the extension, update the TYPO3 core and install the new version 2.0.x. See steps in chapter :ref:`step-by-step-installation`. for further details.

Please note that you possibly need to adjust the arguments of the check script on the Nagios® server and remove ``pid <pageid>`` (or ``--pageid <pageid>``) and replace it with ``--resource /?eID=nagios``. In newer versions of the ``check_typo3.sh`` plugin for Nagios®, even the ``--resource`` parameter is not required. A typical line in the Nagios® configuration file looks like:

::

   check_command check_typo3!--hostname example.com


.. _update-from-2-0-x-to-2-1-x:

Update from version 2.0.x to version 2.1.x
""""""""""""""""""""""""""""""""""""""""""

In version 1.x.x of the extension, the extension list showed the keyword ``version`` between the extension key and the version number. This keyword has been accidentally dropped in version 2.0.x. The Nagios plugin ``check_typo3.sh`` supports both variants: extension list with and without the keyword ``version``. The output of the extension list has been fixed with version 2.1.0 and shows the keyword ``version`` again.

If you update from version 2.0.x to version 2.1.x and use the Nagios plugin version 1.0.0.4 or higher, everything should be fine.

If you update from version 2.0.x to version 2.1.x and use your own scripts or methods to parse the output of ``EXT:nagios``, make sure they support the re-implemented keyword ``version`` between the extension key and the version number.

You can read further details about this issue at https://github.com/schams-net/nagios/issues/6


Removed and Added Features
""""""""""""""""""""""""""

Compared to older versions of the extension, the following features have been **removed** in version 2.0.0:

- TYPO3 dependency warnings for extensions
- basic database details (number of database tables and number of DB processes)
- status of donation notice popup


The following feature has been **added** in version 2.0.0:

- application context


The following feature has been **added** in version 2.2.0:

- database host name
- database name
