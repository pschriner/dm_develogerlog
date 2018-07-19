<?php
namespace DieMedialen\DmDeveloperlog\Domain\Model;

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

/**
 * Constraints for log entry searches
 * This object should never be persisted
 */
class Constraint extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var int
     */
    protected $severity = -1;

    /**
     * @var string
     */
    protected $search = '';

    /**
     * @var string
     */
    protected $extkey = '';

    /**
     * Default constructor
     */
    public function __construct()
    {
    }

    /**
     * added to prevent the deprecation message
     * in Extbase\DomainObject\AbstractDomainObject
     *
     * @todo the constraints model needs another way of storing
     * persisted search data than serialisation
     */
    public function __wakeup()
    {
    }

    /**
     * Set the severity
     *
     * @param string $severity
     */
    public function setSeverity($severity)
    {
        $this->severity = (int)$severity;
    }

    /**
     * Get the severity
     *
     * @return string
     */
    public function getSeverity()
    {
        return $this->severity;
    }

    /**
     * Set the search word
     *
     * @param string $search
     */
    public function setSearch($search)
    {
        $this->search = $search;
    }

    /**
     * Get the search word
     *
     * @return string
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * Set the extension key
     *
     * @param string $extkey
     */
    public function setExtkey($extkey)
    {
        $this->extkey = $extkey;
    }

    /**
     * Get the extension key
     *
     * @return string
     */
    public function getExtkey()
    {
        return $this->extkey;
    }
}
