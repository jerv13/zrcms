<?php

namespace Zrcms\Core\Model;

use Zrcms\Core\Exception\TrackingInvalid;

/**
 * @author James Jervis - https://github.com/jerv13
 */
trait TrackableModifyTrait
{
    use TrackableTrait;

    /**
     * Date object was first modified
     *
     * @var string
     */
    protected $modifiedDate;

    /**
     * Date object was first modified
     * NOTE: this is for internal use ONLY
     *
     * @var \DateTime
     */
    protected $modifiedDateObject;

    /**
     * User ID of creator
     *
     * @var string
     */
    protected $modifiedByUserId;

    /**
     * Short description of create reason
     *
     * @var string
     */
    protected $modifiedReason;

    /**
     * @return string
     * @throws TrackingInvalid
     */
    public function getModifiedDate(): string
    {
        if (empty($this->modifiedDate)) {
            throw new TrackingInvalid(
                'Value not set for modifiedDate in ' . get_class($this)
            );
        }

        return $this->modifiedDate;
    }

    /**
     * @return int
     * @throws TrackingInvalid
     */
    public function getModifiedTimestamp(): int
    {
        return $this->modifiedDateObject->format(Trackable::DATE_FORMAT_TIMESTAMP);
    }

    /**
     * @return \DateTime
     * @throws TrackingInvalid
     */
    public function getModifiedDateObject(): \DateTime
    {
        return $this->modifiedDateObject;
    }

    /**
     * @return string
     * @throws TrackingInvalid
     */
    public function getModifiedByUserId(): string
    {
        if (empty($this->modifiedByUserId)) {
            throw new TrackingInvalid(
                'Value not set for modifiedByUserId in ' . get_class($this)
            );
        }

        return $this->modifiedByUserId;
    }

    /**
     * @return string
     * @throws TrackingInvalid
     */
    public function getModifiedReason(): string
    {
        if (empty($this->modifiedReason)) {
            throw new TrackingInvalid(
                'Value not set for modifiedReason in ' . get_class($this)
            );
        }

        return $this->modifiedReason;
    }

    /**
     * @return bool
     */
    public function hasModifiedData()
    {
        return (!empty($this->modifiedDate) && !empty($this->modifiedByUserId) && empty($this->modifiedReason));
    }

    /**
     * @return void
     * @throws TrackingInvalid
     */
    public function assertHasModifiedData()
    {
        if (empty($this->modifiedDate)) {
            throw new TrackingInvalid(
                'Value not set for modifiedDate in ' . get_class($this)
            );
        }

        if (empty($this->modifiedByUserId)) {
            throw new TrackingInvalid(
                'Value not set for modifiedByUserId in ' . get_class($this)
            );
        }

        if (empty($this->modifiedReason)) {
            throw new TrackingInvalid(
                'Value not set for modifiedReason in ' . get_class($this)
            );
        }
    }

    /**
     * @param string      $modifiedByUserId
     * @param string      $modifiedReason
     * @param string|null $modifiedDate
     *
     * @return void
     * @throws TrackingInvalid
     */
    protected function setModifiedData(
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ) {
        // invalid
        if (empty($modifiedByUserId)) {
            throw new TrackingInvalid(
                'Invalid modifiedByUserId in ' . get_class($this)
            );
        }

        if (empty($modifiedReason)) {
            throw new TrackingInvalid(
                'Invalid modifiedReason in ' . get_class($this)
            );
        }

        $this->modifiedByUserId = $modifiedByUserId;

        // ALWAYS STORE UTC
        $timezone = new \DateTimeZone('UTC');

        if (!is_string($modifiedDate)) {
            $modifiedDateObject = new \DateTime(
                'now',
                $timezone
            );
        } else {
            $modifiedDateObject = \DateTime::createFromFormat(
                Trackable::DATE_FORMAT,
                $modifiedDate,
                $timezone
            );
        }

        $this->modifiedDateObject = $modifiedDateObject;

        $this->modifiedDate = $modifiedDateObject->format(Trackable::DATE_FORMAT);
        $this->modifiedReason = $modifiedReason;
    }
}
