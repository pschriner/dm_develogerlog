.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt

.. _configuration:

Configuration
-----------------

The following properties can be configured in the "Extension Manager" backend module:

Properties
^^^^^^^^^^

.. container:: ts-properties

	==================================== ===================================== ====================
	Property                             Tab                                   Default
	==================================== ===================================== ====================
	minLogLevel_                          basic                                 -1 (=Ok)
	excludeKeys_                          basic                                 TYPO3\CMS\Core\Authentication\AbstractUserAuthentication, TYPO3\CMS\Backend\Template\DocumentTemplate, extbase
	includeCallerInformation_             advanced                              1
	dataCap_                              advanded                              1000000
	==================================== ===================================== ====================

Property details
^^^^^^^^^^^^^^^^

.. only:: html

   .. contents::
        :local:
        :depth: 1

.. _configuration-minLogLevel:

minLogLevel
"""""""""""
Minimum log level (-1 = Ok to 3 = Error)

.. _configuration-excludeKeys:

excludeKeys
"""""""""""

Keys that are not logged. Some very talkative keys are excluded by default

.. _configuration-includeCallerInformation:

includeCallerInformation
""""""""""""""""""""""""
If set, caller information will be retrieved for each devlog call. There is almost no good reason not to include this information.

.. _configuration-dataCap:

dataCap
"""""""
A limit to how much additional data (in characters) is logged with each call. Everything beyond this limit will be truncated. As the data is stored via json_encode this will lead to the data not being decodeable.