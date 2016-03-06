

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

.. _nagios-server-plugin:


Nagios Server Plugin Configuration
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Prerequisites
"""""""""""""

Install the TYPO3 extension on the TYPO3 instance which should be monitored.

At the Nagios® server side, install Nagios® `as documented <https://www.nagios.org/documentation/>`_. The following sections assume Nagios® is fully operational, configured and tested. We also assume that all Nagios® plugins are located in:

::

	/usr/local/nagios/libexec/


Download
""""""""

Download the TYPO3 CMS check plugin for Nagios® from the official `Nagios® Exchange portal <https://exchange.nagios.org/>`_ (search for "TYPO3"). The file name is typically ``nagios-check_typo3-1.0.0.3.tar.gz`` (version 1.0.0.3).


Plugin Installation
"""""""""""""""""""

Extract the downloaded ``.tar.gz``-archive and copy the following files:

- ``libexec/check_typo3.sh`` to ``/usr/local/nagios/libexec/``
- ``etc/check_typo3.cfg`` to ``/usr/local/nagios/etc/``

Make sure the file permissions are correct, for example (depending on your individual system):

::

   chown nagios /usr/local/nagios/libexec/check_typo3.sh
   chmod 755 /usr/local/nagios/libexec/check_typo3.sh
   chmod 644 /usr/local/nagios/etc/check_typo3.cfg


Plugin Activation
"""""""""""""""""

As the next step, integrate the "TYPO3 check" in your Nagios® configuration. For example:

::

    define command {
      command_name            check_typo3
      command_line            $USER1$/check_typo3.sh $ARG1$
    }

    define service {
      use                     generic-service
      host_name               example
      service_description     TYPO3
      check_command           check_typo3!--hostname example.com
      normal_check_interval   360
      retry_check_interval    10
      notifications_enabled   1
    }


Please note that this is an example only. Change *example.com* accordingly: this is the fully qualified host name of your TYPO3 instance (the website you monitor). The configuration ``normal_check_interval`` defines how often this service should be checked under normal condition (in minutes). A value of "360" means every 6 hours.

Reload (or restart) the Nagios® server and check if everything works as expected or if the server reports an error. A successful reload looks like:

::

	Running configuration check...done.
	Reloading nagios configuration...done


If the Nagios® server reports a configuration error, you made a mistake in one of the configuration files. In this case, check and correct your Nagios® configuration. A failed reload looks like to following example:

::

	Running configuration check... CONFIG ERROR!
	Reload aborted. Check your Nagios configuration.


Assuming the reload/restart of the Nagios® server was successful, you can customise your configuration. Execute the "check\_typo3.sh" script in the command line to list all available options.
