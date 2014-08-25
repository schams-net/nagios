

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

This section describes the best practice to update an existing version of the TYPO3 extension to a newer version.

Update from version 1.0.x to version 1.2.x
""""""""""""""""""""""""""""""""""""""""""

The most important change in version 1.2.x compared to older versions of this extension is the introduction of eID, which makes the installation of the extension on a special page obsolete. With eID you can access the output by using the following URL (without addressing a specific page ID):

::

   http://www.your-domain.com/?eID=nagios

All versions up to 1.2.5 support the method of accessing the TYPO3 Nagios® extension on a page but it is highly recommended to change the setup to use the eID (note: this also requires to change the configuration of your check script on the Nagios® server).

If you update from version 1.0.x to version 1.2.x, you come across the extension configuration during the installation process. Ensure you enable the features you want to monitor as usual and do not forget to add the IP address(es) of the Nagios® server.

Change the arguments of the check script on the Nagios® server and remove “-pid <pageid>” (or “--pageid <pageid>”) and replace it with “ **--resource /?eID=nagios** ”. A typical line in the Nagios® configuration file could look like:

::

   check_typo3!--hostname your-domain.com --resource /?eID=nagios

Check, if the new configuration works (reload Nagios® server and re-schedule the appropriate check). If everything is fine, you can delete the page in the TYPO3 backend, where the TYPO3 extensions was installed on.

Update from version 1.2.x to the latest 1.2.x
"""""""""""""""""""""""""""""""""""""""""""""

There are no breaking changes and an update process is straight forward. Just download and install the new version and replace the previous one. You possibly want to check, if there are any new features (checks) available you would like to enable/disable, see chapter :ref:`configuration`.
