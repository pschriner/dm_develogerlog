<?php
namespace DieMedialen\DmDeveloperlog\Utility;

/*
 * This file is part of the TYPO3 CMS project.
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
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Developerlog {

    /** @var string $extkey  */
    protected $extKey = 'dm_developerlog';

    /** @var array $extConf */
    protected $extConf = array(
        'minLogLevel' => 1,
        'excludeKeys' => 'TYPO3\CMS\Core\Authentication\AbstractUserAuthentication, TYPO3\CMS\Backend\Template\DocumentTemplate, extbase',
        'dataCap' => 1000000,
        'includeCallerInformation' => 1
    );

    /** @var string $request_id */
    protected $request_id = '';

    /** @var int $request_type */
    protected $request_type = 0;

    /** @var array $excludeKeys */
    protected $excludeKeys = array();

    /** @var int $currentPageId */
    protected $currentPageId = null;
    
    protected $systemSearch = '/sysext/';
    
    protected $systemSearchLength = 8;
    
    protected $extSeach = '/typo3conf/ext/';
    
    protected $extSearchLength = 15;

    /**
     * @var array $requestTypeMap Sad duplicate from \TYPO3\CMS\Core\Core\Bootstrap
     */
    protected $requestTypeMap = [
        1 => 'TYPO3_REQUESTTYPE_FE',
        2 => 'TYPO3_REQUESTTYPE_BE',
        4 => 'TYPO3_REQUESTTYPE_CLI',
        8 => 'TYPO3_REQUESTTYPE_AJAX',
        16 => 'TYPO3_REQUESTTYPE_INSTALL'
    ];

    /**
     * Constructor
     * The constructor just reads the extension configuration and stores it in a member variable
     */
    public function __construct()
    {
        $extConf = array();
        if (isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey])) {
            $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);
        }
        $this->extConf = array_merge($this->extConf, $extConf);
        $this->request_id = \TYPO3\CMS\Core\Core\Bootstrap::getInstance()->getRequestId();
        $this->request_type = TYPO3_REQUESTTYPE;
        $this->excludeKeys = GeneralUtility::trimExplode(',', $this->extConf['excludeKeys'], TRUE);
    }

    /**
     * Developer log
     * Parameter is an array containing at most
     * 'msg'		string		Message (in english).
     * 'extKey'		string		Extension key (from which extension you are calling the log)
     * 'severity'	integer		Severity: 0 is info, 1 is notice, 2 is warning, 3 is fatal error, -1 is "OK" message
     * 'dataVar'	mixed		Additional data you want to pass to the logger. This should be an array,
     * but anything but a resource should work
     *
     * @param array $logArray: log data array
     * @return void
     */
    public function devLog($logArray)
    {
        $minLogLevel = -1;
        if ($this->extConf['minLogLevel'] !== '') {
            $minLogLevel = (int)$this->extConf['minLogLevel'];
        }
        if ((int)$logArray['severity'] < $minLogLevel) {
            return;
        }

        if (in_array($logArray['extKey'], $this->excludeKeys)) {
            return;
        }
        $insertFields = $this->getBasicDeveloperLogInformation($logArray);

        if (!empty($this->extConf['includeCallerInformation'])) {
            $callerData = $this->getCallerInformation(debug_backtrace(false));
            $insertFields['location'] = $callerData['location'];
            $insertFields['line'] = $callerData['line'];
            $insertFields['system'] = $callerData['system'];
        }

        if ($this->extConf['dataCap'] !== 0 && isset($logArray['dataVar']) && !is_resource($logArray['dataVar'])) {
            $insertFields['data_var'] = $this->getExtraData($logArray['dataVar']);
        }
        $db = $this->getDatabaseConnection();
        if ($db !== NULL) { // this can happen when devLog is called to early in the bootstrap process
            @$db->exec_INSERTquery('tx_dmdeveloperlog_domain_model_logentry', $insertFields);
        }
    }

    /**
     * Get the current page ID (if cheaply available)
     *
     * @return int
     */
    protected function getCurrentPageId()
    {
        if ($this->currentPageId !== null) {
            return $this->currentPageId;
        }
        if (TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_FE) {
            $this->currentPageId = $GLOBALS['TSFE']->id ?: 0;
        } else {
            $singletonInstances = GeneralUtility::getSingletonInstances();
            if (isset($singletonInstances['TYPO3\CMS\Extbase\Configuration\BackendConfigurationManager'])) { // lucky us, that guy is clever
                $backendConfigurationManager = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Configuration\BackendConfigurationManager', GeneralUtility::makeInstance('TYPO3\CMS\Core\Database\QueryGenerator'));
                // getDefaultBackendStoragePid() because someone made getCurrentPageId() protected
                $this->currentPageId = $backendConfigurationManager->getDefaultBackendStoragePid();
            } else {  // simplified backend check
                $this->currentPageId =  GeneralUtility::_GP('id') !== null ? (int)GeneralUtility::_GP('id') : 0;
            }
        }
        return $this->currentPageId;
    }

    /**
     * Gather some basic log data
     *
     * @param array $logArray
     *
     * @return array
     */
    protected function getBasicDeveloperLogInformation($logArray)
    {
        $insertFields = array(
            'pid' => $this->getCurrentPageId(),
            'crdate' => microtime(true),
            'request_id' => $this->request_id,
            'request_type' => $this->request_type,
            'line' => 0,
        );

        if (isset($GLOBALS['BE_USER']) && isset($GLOBALS['BE_USER']->user['uid']))
        {
            $insertFields['be_user'] = (int)$GLOBALS['BE_USER']->user['uid'];
            $insertFields['workspace_uid'] = (int)$GLOBALS['BE_USER']->workspace;
        }

        if (isset($GLOBALS['TSFE']) && isset($GLOBALS['TSFE']->fe_user->user['uid']))
        {
            $insertFields['fe_user'] = (int)$GLOBALS['TSFE']->fe_user->user['uid'];
        }

        $insertFields['message'] = GeneralUtility::removeXSS($logArray['msg']);

        // There's no reason to have any markup in the extension key
        $insertFields['extkey'] = strip_tags($logArray['extKey']);

        // Severity can only be a number
        $insertFields['severity'] = intval($logArray['severity']);
        return $insertFields;
    }

    /**
     * JSON-encode the extra data provided
     *
     * @param mixed $extraData
     * @return string
     */
    protected function getExtraData($extraData)
    {
        $serializedData = json_encode($extraData, JSON_PARTIAL_OUTPUT_ON_ERROR | JSON_PRETTY_PRINT);
        if ($serializedData !== FALSE) {
            if (isset($this->extConf['dataCap'])) {
                return substr($serializedData, 0, min(strlen($serializedData), (int)$this->extConf['dataCap']));
            } else {
                return $serializedData;
            }
        }
        return '';
    }

    /**
     * Given a backtrace, this method tries to find the place where a "devLog" function was called
     * and return info about the place
     *
     * @param array $backTrace: function call backtrace, as provided by debug_backtrace()
     *
     * @return array information about the call place
     */
    protected function getCallerInformation($backtrace)
    {
        $system = 0;
        foreach ($backtrace as $entry) {
            if ($entry['class'] !== self::class && $entry['function'] === 'devLog') {
                $file = $entry['file'];
                if (strpos($file, $this->extSeach) > 0) {
                    $file = substr($file, strpos($file, $this->extSeach) + $this->extSearchLength);
                } elseif (strpos($file, $this->systemSearch) > 0) {
                    $file = substr($file, strpos($file, $this->systemSearch) + $this->systemSearchLength);
                    $system = TRUE;
                } else {
                    $file = basename($file);
                }
                return array(
                    'location' => $file,
                    'line' => $entry['line'],
                    'system' => $system
                );
            }
        }
        return array(
            'location' => '--- unknown ---',
            'line' => 0,
            'system' => $system
        );
    }

    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}