.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt

.. _LoggingAPI: https://docs.typo3.org/typo3cms/CoreApiReference/ApiOverview/Logging/Index.html

.. _logwriter:

LogWriter
============

As of TYPO3 9 the devLog mechanism is deprecated. The recommended way is to use the standard LoggingAPI_.

The LogWriter class is :code:`\DieMedialen\DmDeveloperlog\Log\Writer\DeveloperlogWriter`.

Note
----

When used as a LogWriter, dm_developerlog will ignore all configuration settings (as the Logging API provides them differently).

Usage
-----

.. code-block:: php

    $GLOBALS['TYPO3_CONF_VARS']['LOG']['TYPO3']['CMS']['Backend']['writerConfiguration'] = [
        \TYPO3\CMS\Core\Log\LogLevel::ERROR => [
            'DieMedialen\\DmDeveloperlog\\Log\\Writer\\DeveloperlogWriter' => []
         ]
    ];

to add file / location data, you have to configure a suitable processor

.. code-block:: php

    $GLOBALS['TYPO3_CONF_VARS']['LOG']['TYPO3']['CMS']['Backend']['processorConfiguration'] = [
        \TYPO3\CMS\Core\Log\LogLevel::ERROR => [
            'TYPO3\\CMS\\Core\\Log\\Processor\\IntrospectionProcessor' => [
                'appendFullBackTrace' => TRUE
            ]
        ]
    ];
