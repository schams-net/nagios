# Step-by-Step Installation

This section describes the installation steps in detail. The labels and exact steps may slightly vary depending on the TYPO3 version you are using and your individual site configuration.


## Extension Manager

If your TYPO3 instance was installed using the *classic* installation method, use the Extension Manager to download and install the TYPO3 extension.

**Step 1:** Log-in to the TYPO3 backend as user with system maintainer privileges.

**Step 2:** Go to “Admin Tools → Extensions”.

**Step 3:** Make sure that the list of available extensions (the *extension list*) is up-to-date.

**Step 4:** Search for the extension key `nagios` and click the “Import and Install” icon of the appropriate item in the list.

**Step 5:** TYPO3 automatically activates extensions. However, this feature can be disabled in some versions of TYPO3. If the extension does not appear as *activated* in the “Installed Extensions” tab, activate it manually by clicking the icon left-hand-side.


## Composer

The officially recommended TYPO3 installation method is using [Composer](https://getcomposer.org). The TYPO3 extension “Nagios” is therefore also available as a Composer package. This makes the installation process and updates in the future super-easy. Execute the following command in TYPO3's project folder, if the TYPO3 instance was installed using Composer:

```bash
composer require schams-net/nagios
```

Composer resolves dependencies automatically and downloads the best possible version for your environment. You can also specify the desired extension version directly. The following command installs version 3.0.1 (if possible) and ensures that it remains at exactly this version when you run a `composer update` in the future:

```bash
composer require schams-net/nagios:3.0.1
```

The fixation of a specific version is, however, not recommended. Bugfixes, security updates, and backwards-compatible new versions would not be installed. The TYPO3 extension follows [semantic versioning](https://semver.org).

Once the extension has been downloaded and added to your TYPO3 instance, you possibly need to activate it. This can be done in the TYPO3 backend using the Extension Manager.


## Next Steps

Once the extension has been activated, you should configure the details that the system should output. The chapter [Administration and Configuration](../../AdministrationAndConfiguration/Index.md) describes the options in detail.

Please note that you also have to install and set up the counterpart: the Nagios® server and the Nagios® `check_typo3.sh` plugin. The chapter [Nagios® Server Plugin](NagiosServerPlugin/Index.md) briefly explains this process later.

---

➤ Read next: [Version Updates](../VersionUpdates/Index.md)
