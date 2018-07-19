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
 * A log entry
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
    protected $requestId;

    /**
     * @var int
     */
    protected $requestType;

    /**
     * @var int
     */
    protected $beUser;

    /**
     * @var int
     */
    protected $feUser;

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

    /**
     * @var bool
     */
    protected $system;

    /**
     * Get the creation date
     *
     * @return DateTime
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * Get the request ID
     *
     * @return string
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * Get the request type. This is a bitmasked value.
     * The bitmask is defined in \TYPO3\CMS\Core\Bootstrap
     *
     * @return int
     */
    public function getRequestType()
    {
        return $this->requestType;
    }

    /**
     * Get the backend user UID.
     * Even on a frontend request this can be defined.
     * It's an int for performance reasons.
     *
     * @return int
     */
    public function getBeUser()
    {
        return $this->beUser;
    }

    /**
     * Get the frontend user UID.
     * It's an int for performance reasons.
     *
     * @return int
     */
    public function getFeUser()
    {
        return $this->feUser;
    }

    /**
     * Get the line on which the devLog method was called
     *
     * @return int
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * Get the file in which the devLog method was called
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Get the extension key
     * Even though it is defined as "Extension Key" this is not enforced
     *
     * @return string
     */
    public function getExtkey()
    {
        return $this->extkey;
    }

    /**
     * Get the message passed to "devLog"
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get the severity of the "devLog" call
     *
     * @return int
     */
    public function getSeverity()
    {
        return $this->severity;
    }

    /**
     * Get the additional data provided for the "devLog" call
     * This is a json_encoded something. As it is stored partially if encoding fails
     * there is no guarantee that it can be decoded
     *
     * @return string
     */
    public function getDataVar()
    {
        return $this->dataVar;
    }

    /**
     * Get workspace UID
     *
     * @return int
     */
    public function getWorkspaceUid()
    {
        return (int)$this->workspaceUid;
    }

    /**
     * Check whether this extension thinks the devLog call came from a
     * system extension (naive check via file path).
     *
     * @return bool
     */
    public function isSystemLogEntry()
    {
        return $this->system;
    }
}
