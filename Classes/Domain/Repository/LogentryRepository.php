<?php
namespace DieMedialen\DmDeveloperlog\Domain\Repository;

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

/**
 * Develooer log entry repository
 */
class LogentryRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    
    protected $defaultOrderings = array(
        'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING,
        'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
    );
    
    /**
     * Initialize some local variables to be used during creation of objects
     *
     * @return void
     */
    public function initializeObject()
    {
        /** @var $defaultQuerySettings \TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface */
        $defaultQuerySettings = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface::class);
        $defaultQuerySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($defaultQuerySettings);
    }

    /**
     * @param \DieMedialen\DmDeveloperlog\Domain\Model\Constraint $constraint
     */
    public function findByConstraint(\DieMedialen\DmDeveloperlog\Domain\Model\Constraint $constraint = NULL)
    {
        if ($constraint == NULL) {
            return $this->findAll();
        }
        $and = [];
        
        $query = $this->createQuery();
        $severity = $constraint->getSeverity();
        if ((int)$severity!==-1) {
            $and['severity'] = $query->greaterThanOrEqual('severity', $severity);
        }
        
        $search = $constraint->getSearch();
        if ($search !== '') {
            $and['search'] = $query->like('message', '%'.$search.'%');
        }
        
        $extkey = $constraint->getExtkey();
        if ($extkey !== '') {
            $and['extkey'] = $query->equals('extkey', $extkey);
        }
        
        if (count($and) > 1) {
            return $query->matching($query->logicalAnd($and))->execute();
        } elseif (count($and)) {
            return $query->matching(current($and))->execute();
        } else {
            return $this->findAll();
        }
        
        
    }
    
    public function getExtensionKeys()
    {
        $extKeys =  $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
            'extkey',
            'tx_dmdeveloperlog_domain_model_logentry',
            '1=1',
            'extkey',
            'extkey',
            '',
            'extkey'
        );
        return array_combine(array_keys($extKeys),array_keys($extKeys));
    }
}