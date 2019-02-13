<?php
namespace DieMedialen\DmDeveloperlog\Log\Writer;

/*
 * This file is part of the dm_developerlog project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Log\Writer\AbstractWriter;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class DeveloperlogWriter extends AbstractWriter
{
    protected $logTable = 'tx_dmdeveloperlog_domain_model_logentry';

    protected $systemSearch = '/sysext/';

    protected $systemSearchLength = 8;

    protected $extSeach = '/typo3conf/ext/';

    protected $extSearchLength = 15;

    /**
     * Write record to developer log table
     *
     * @param \TYPO3\CMS\Core\Log\LogRecord $record
     */
    public function writeLog(\TYPO3\CMS\Core\Log\LogRecord $record)
    {
        $insertFields = [
            'pid' => $this->getCurrentPageId(),
            'crdate' => $record->getCreated(),
            'tstamp' => time(),
            'request_id' => $record->getRequestId(),
            'request_type' => TYPO3_REQUESTTYPE,
            'message' => $record->getMessage(),
            'extkey' => $record->getComponent(),
        ];

        $callerData = $this->getCallerData($record->getData());

        $insertFields['location'] = $callerData['location'];
        $insertFields['line'] = $callerData['line'];
        $insertFields['system'] = $callerData['system'];

        $insertFields['data_var'] = json_encode($record->getData(), JSON_PARTIAL_OUTPUT_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if (isset($GLOBALS['BE_USER']) && isset($GLOBALS['BE_USER']->user['uid'])) {
            $insertFields['be_user'] = (int)$GLOBALS['BE_USER']->user['uid'];
            $insertFields['workspace_uid'] = (int)$GLOBALS['BE_USER']->workspace;
        }

        if (isset($GLOBALS['TSFE']) && isset($GLOBALS['TSFE']->fe_user->user['uid'])) {
            $insertFields['fe_user'] = (int)$GLOBALS['TSFE']->fe_user->user['uid'];
        }
        $this->createLogEntry($insertFields);
    }

    protected function isSystemSource($component)
    {
        if (strpos($component, 'TYPO3\CMS') > -1) {
            return true;
        }
        return false;
    }

    /**
     * Add extra call data from the IntrospectionProcessor
     */
    protected function getCallerData($data)
    {
        $system = false;
        if (is_array($data['backtrace'])) {
            $firstRecord = reset($data['backtrace']);
        } else {
            $firstRecord = $data;
        }
        $file = isset($firstRecord['file']) ? $firstRecord['file'] : '';
        if (strpos($file, $this->extSeach) > 0) {
            $file = substr($file, strpos($file, $this->extSeach) + $this->extSearchLength);
        } elseif (strpos($file, $this->systemSearch) > 0) {
            $file = substr($file, strpos($file, $this->systemSearch) + $this->systemSearchLength);
            $system = true;
        } else {
            $file = basename($file);
        }
        return [
            'location' => $file,
            'line' => (int)(isset($firstRecord['line']) ? $firstRecord['line'] : 0),
            'system' => $system,
        ];
    }

    /**
     * Get the current page ID (if cheaply available)
     *
     * @return int
     */
    protected function getCurrentPageId()
    {
        $currentPageId = 0;
        if (TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_FE) {
            $currentPageId = $GLOBALS['TSFE']->id ?: 0;
        } else {
            $singletonInstances = GeneralUtility::getSingletonInstances();
            if (isset($singletonInstances[BackendConfigurationManager::class])) { // lucky us, that guy is clever
                $backendConfigurationManager = GeneralUtility::makeInstance(
                    BackendConfigurationManager::class,
                    GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\QueryGenerator::class)
                );
                // getDefaultBackendStoragePid() because someone made getCurrentPageId() protected
                $currentPageId = $backendConfigurationManager->getDefaultBackendStoragePid();
            } else {  // simplified backend check
                $currentPageId = GeneralUtility::_GP('id') !== null ? (int)GeneralUtility::_GP('id') : 0;
            }
        }
        return $currentPageId;
    }

    /**
     * @return \TYPO3\CMS\Core\Database\DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }

    protected function createLogEntry($insertFields)
    {
        if (class_exists(ConnectionPool::class)) {
            GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($this->logTable)
                ->insert(
                    $this->logTable,
                    $insertFields
                );
        } else {
            $db = $this->getDatabaseConnection();
            if ($db !== null) { // this can happen when devLog is called to early in the bootstrap process
                @$db->exec_INSERTquery($this->logTable, $insertFields);
            }
        }
    }
}
