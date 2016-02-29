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
 * Constraints for log entries
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
    
    public function setSeverity($severity)
    {
        $this->severity = (int)$severity;
    }
    
    public function getSeverity(){
        return $this->severity;
    }
    
    public function setSearch($search)
    {
        $this->search = $search;
    }
    
    public function getSearch()
    {
        return $this->search;
    }
   
    public function setExtkey($extkey) 
    {
        $this->extkey = $extkey;
    }
    
    public function getExtkey()
    {
        return $this->extkey;
    }
}