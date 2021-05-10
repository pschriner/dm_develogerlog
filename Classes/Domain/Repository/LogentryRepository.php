<?php
declare(strict_types=1);
namespace DieMedialen\DmDeveloperlog\Domain\Repository;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;

class LogentryRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    protected $tableName = '';

    protected $defaultOrderings = [
        'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING,
        'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING,
    ];

    /**
     * Initialize some local variables to be used during creation of objects
     */
    public function initializeObject()
    {
        /** @var $defaultQuerySettings \TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface */
        $defaultQuerySettings = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface::class);
        $defaultQuerySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($defaultQuerySettings);

        $datamapFactory = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapFactory::class);
        $datamap = $datamapFactory->buildDataMap($this->objectType);
        $this->tableName = $datamap->getTableName();
    }

    /**
     * @param \DieMedialen\DmDeveloperlog\Domain\Model\Constraint $constraint
     */
    public function findByConstraint(\DieMedialen\DmDeveloperlog\Domain\Model\Constraint $constraint = null)
    {
        if ($constraint == null) {
            return $this->findAll();
        }
        $and = [];

        $query = $this->createQuery();
        $severity = $constraint->getSeverity();
        if ((int)$severity !== -1) {
            $and['severity'] = $query->greaterThanOrEqual('severity', $severity);
        }

        $search = $constraint->getSearch();
        if ($search !== '') {
            $and['search'] = $query->logicalOr(
                $query->like('message', '%' . $search . '%'),
                $query->like('dataVar', '%' . $search . '%')
            );
        }

        $extkey = $constraint->getExtkey();
        if ($extkey !== '') {
            $and['extkey'] = $query->equals('extkey', $extkey);
        }

        if (count($and) > 1) {
            return $query->matching($query->logicalAnd($and))->execute();
        }
        if (count($and)) {
            return $query->matching(current($and))->execute();
        }

        return $this->findAll();
    }

    /**
     * Force delete all entries
     * @override
     */
    public function removeAll()
    {
        GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getConnectionForTable($this->tableName)
            ->truncate(
                $this->tableName
            );
    }

    /**
     * @return \TYPO3\CMS\Core\Database\DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }

    /**
     * Get all distinct extension keys
     * @return array
     */
    public function getExtensionKeys()
    {
        return $this->getDistinctOptions('extkey');
    }

    /**
     * Get all distinct values for a given field
     * @param string $field
     * @return array
     */
    protected function getDistinctOptions($field)
    {
        $values = [];
        $queryBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getQueryBuilderForTable($this->tableName);
        $rows = $queryBuilder->select($field)
            ->from($this->tableName)
            ->orderBy($field, 'ASC')
            ->groupBy($field)
            ->execute()
            ->fetchAll();
        foreach ($rows as $row) {
            $values[$row[$field]] = $row[$field];
        }

        return array_combine(array_keys($values), array_keys($values));
    }

    /**
     * Get all distinct frontend users
     * @return array
     */
    public function getFrontendUsers()
    {
        return $this->getDistinctOptions('fe_user');
    }

    /**
     * Get all distinct backend users
     * @return array
     */
    public function getBackendUsers()
    {
        return $this->getDistinctOptions('be_user');
    }
}
