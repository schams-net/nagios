# Version Updates

## Major Versions

Please note that the major versions of the TYPO3 extension “Nagios” (these are v2.x and v3.x) are redevelopments. As no data is stored in the TYPO3 instance, an upgrade from one major version to another is straight forward in most cases.

The recommended steps are as follows:

1. Deactivate and remove the current (old) version of the TYPO3 extension “Nagios”.
2. Install and activate the new version of the TYPO3 extension “Nagios” (see [step-by-step installation](../StepByStep/Index.md)).
3. Open, review, and edit the [extension configuration](../../AdministrationAndConfiguration/Index.md).
4. Save the configuration (even if no changes have been made).
5. Review and update the configuration of the Nagios® “Check TYPO3” plugin as required (see [Nagios® Server Plugin](../NagiosServerPlugin/Index.md)).


## Specific Update/Upgrade Requirements

### Updates from v1.x

The TYPO3 extension “Nagios” version 1.x output the data on a page in the frontend of the instance. This method required the argument `-pid <pageid>` or `--pageid <pageid>` to address the respective page.

As this argument has changed, you have to update the Nagios® plugin configuration when you upgrade to a newer major versions of the extension.


### Updates from v2.0.x to v2.1.x or v3.x

All versions of the TYPO3 extension “Nagios” output the extension list including the keyword `version` by default. For example:

```text
EXT:news-version-8.5.1
```

Version 2.0.x of the TYPO3 extension “Nagios”, however, omits the keyword `version`. For example:

```text
EXT:news-8.5.1
```

If you update from version 2.0.x to a new version, for example version 2.1.x or 3.x, I recommend that you check and possibly update the Nagios® “Check TYPO3” plugin script and its configuration.

Read more  about this issue at <https://github.com/schams-net/nagios/issues/6>.


### Updates from v1.x or v2.x to v3.x

The TYPO3 extension “Nagios” version 3.x is a redevelopment. The extension now implements a PSR-15 compatible [middleware](https://docs.typo3.org/m/typo3/reference-coreapi/master/en-us/ApiOverview/RequestHandling/Index.html). This possibly requires an update of the Nagios® “Check TYPO3” plugin script and/or its configuration. See the [next chapter](../NagiosServerPlugin/Index.md) for details.

Some [features](../../AdministrationAndConfiguration/Configuration/Features/Index.md) have been removed from the TYPO3 extension “Nagios” in version 3.x. Removed features are for example:

- disk space
- database
- server name

If your monitor solution requires these features, they can be re-implemented by extending the middleware. See chapter [Extending Functionality](../../ExtendingFunctionality/Index.md) for further details.

---

➤ Read next: [Nagios® server plugin](../NagiosServerPlugin/Index.md)
