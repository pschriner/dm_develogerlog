<?php
namespace DieMedialen\DmDeveloperlog\Domain\Model;

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
 * A developer log entry
 */
class Logentry extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var \DateTime
     */
    protected $crdate;
    
    /**
     * @var string
     */
    protected $crmsec;
    
    /**
     * @var int
     */
    protected $cruser_id;
    
    /**
     * @var int
     */
    protected $line;
    
    /**
     * @var string
     */
    protected $location;
    
    /**
     * @var string
     */
    protected $extkey;
    
    /**
     * @var string
     */
    protected $message;
    
    /**
     * @var int
     */
    protected $severity;
    
    /**
     * @var string
     */
    protected $dataVar;
    
    /**
     * @var int
     */
    protected $workspaceUid;
    
    public function getCrdate() {
        return $this->crdate;
    }
    
    /**
     * @return string
     */
    public function getCrmsec() {
        return $this->crmsec;
    }
    
    /**
     * @return int
     */
    public function getCruserId() {
        return $this->cruser_id;
    }
    
    /**
     * @return int
     */
    public function getLine() {
        return $this->line;
    }
    
    /**
     * @return string
     */
    public function getLocation() {
        return $this->location;
    }
    
    /**
     * @return string
     */
    public function getExtkey() {
        return $this->extkey;
    }
    
    /**
     * @return string
     */
    public function getMessage() {
        return $this->message;
    }
    
    /**
     * @return int
     */
    public function getSeverity() {
        return $this->severity;
    }
    
    /**
     * @return string
     */
    public function getDataVar() {
        return $this->dataVar;
    }
    
    /**
     * Set workspace uid
     *
     * @param int $workspaceUid
     * @return void
     */
    public function setWorkspaceUid($workspaceUid)
    {
        $this->workspaceUid = $workspaceUid;
    }

    /**
     * Get workspace
     *
     * @return int
     */
    public function getWorkspaceUid()
    {
        return (int)$this->workspaceUid;
    }
}