

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


Secure Socket Layer (SSL)
^^^^^^^^^^^^^^^^^^^^^^^^^

In addition the Nagios® plugin ``check_typo3.sh`` supports encrypted SSL requests (HTTPS) as well as basic/digest HTTP access authentication (HTTP 401). In short words, this means the TYPO3 web server could be configured to require username/password authentication from the Nagios® server (and refuse requests without correct credentials).

Due to the fact that the "Nagios® side" is not part of this documentation, please refer to the manual at `schams.net <https://schams.net/nagios>`_ or check out the documentation shipped with the Nagios® plugin ``check_typo3.sh``.
