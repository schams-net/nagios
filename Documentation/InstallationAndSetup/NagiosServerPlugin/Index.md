# Nagios® Server Plugin

## Prerequisites

Install the TYPO3 extension “Nagios” on the TYPO3 instance that should be monitored as described in section [Step-by-Step Installation](../StepByStep/Index.md).

Install a Nagios® instance [as documented](https://www.nagios.org/documentation/).

The following sections assume that Nagios® is fully operational, configured, and has been tested. I also assume that all Nagios® plugins are located in: `/usr/local/nagios/libexec/`. Replace this path according to your individual setup if required.


## Download

Download the Nagios® “Check TYPO3” plugin from the official [Nagios® Exchange portal](https://exchange.nagios.org/) (search for the keyword `TYPO3` and look for the author `schams.net`). The file name of the archive file is typically `nagios-check_typo3-1.0.0.5.tar.gz` (for version 1.0.0.5).


## Plugin Installation

Extract the downloaded `.tar.gz`-archive and copy the following files:

- `libexec/check_typo3.sh` to `/usr/local/nagios/libexec/`
- `etc/check_typo3.cfg` to `/usr/local/nagios/etc/`

Make sure that the file permissions are correct, for example (depending on your individual system):

```bash
chown nagios /usr/local/nagios/libexec/check_typo3.sh
chmod 755 /usr/local/nagios/libexec/check_typo3.sh
chmod 644 /usr/local/nagios/etc/check_typo3.cfg
```


## Plugin Activation

Integrate the “TYPO3 check” in your Nagios® configuration. For example:

```text
define command {
  command_name            check_typo3
  command_line            $USER1$/check_typo3.sh $ARG1$
}

define service {
  use                     generic-service
  host_name               example
  service_description     TYPO3
  check_command           check_typo3!--hostname example.com --resource /nagios
  normal_check_interval   360
  retry_check_interval    10
  notifications_enabled   1
}
```

Please note that this is an example only. Change `example.com` accordingly: this is the fully qualified host name of your TYPO3 instance (the website you monitor). The argument `--resource` defines the URI of the TYPO3 middleware. Although the default value should be `/nagios`, you can change the expected URI in the [extension configuration](../../AdministrationAndConfiguration/Configuration/Index.md) if required.

The configuration `normal_check_interval` defines how often this service should be checked under normal condition (in minutes). The value “360” means every 6 hours.

Reload (or restart) the Nagios® server and check if everything works as expected. A successful reload looks like:

> ```text
> Running configuration check...done.
> Reloading nagios configuration...done
> ```

If the Nagios® server reports a configuration error, check and update your Nagios® configuration. A failed reload looks like:

> ```text
> Running configuration check... CONFIG ERROR!
> Reload aborted. Check your Nagios configuration.
> ```

Assuming the reload/restart of the Nagios® server was successful, you can now customise your configuration.

---

➤ Next chapter: [Administration and Configuration](../../AdministrationAndConfiguration/Index.md)
