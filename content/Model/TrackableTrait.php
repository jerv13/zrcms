<?php

namespace Zrcms\Content\Model;

use Zrcms\Content\Exception\TrackingException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
trait TrackableTrait
{
    /**
     * Date object was first created
     *
     * @var \DateTime
     */
    protected $createdDate;

    /**
     * User ID of creator
     *
     * @var string
     */
    protected $createdByUserId;

    /**
     * Short description of create reason
     *
     * @var string
     */
    protected $createdReason;

    /**
     * @return string
     * @throws TrackingException
     */
    public function getCreatedDate(): string
    {
        if (empty($this->createdDate)) {
            throw new TrackingException(
                'Value not set for createdDate in ' . get_class($this)
            );
        }

        return $this->createdDate;
    }

    /**
     * @return string
     * @throws TrackingException
     */
    public function getCreatedByUserId(): string
    {
        if (empty($this->createdByUserId)) {
            throw new TrackingException(
                'Value not set for createdByUserId in ' . get_class($this)
            );
        }

        return $this->createdByUserId;
    }

    /**
     * @return string
     * @throws TrackingException
     */
    public function getCreatedReason(): string
    {
        if (empty($this->createdReason)) {
            throw new TrackingException(
                'Value not set for createdReason in ' . get_class($this)
            );
        }

        return $this->createdReason;
    }

    /**
     * @return bool
     */
    public function hasTrackingData()
    {
        return (!empty($this->createdDate) && !empty($this->createdByUserId) && empty($this->createdReason));
    }

    /**
     * @return void
     * @throws TrackingException
     */
    public function assertHasTrackingData()
    {
        if (empty($this->createdDate)) {
            throw new TrackingException(
                'Value not set for createdDate in ' . get_class($this)
            );
        }

        if (empty($this->createdByUserId)) {
            throw new TrackingException(
                'Value not set for createdByUserId in ' . get_class($this)
            );
        }

        if (empty($this->createdReason)) {
            throw new TrackingException(
                'Value not set for createdReason in ' . get_class($this)
            );
        }
    }

    /**
     * @param string $createdByUserId
     * @param string $createdReason
     *
     * @return void
     * @throws TrackingException
     */
    protected function setCreatedData(
        string $createdByUserId,
        string $createdReason
    ) {
        // invalid
        if (empty($createdByUserId)) {
            throw new TrackingException(
                'Invalid createdByUserId in ' . get_class($this)
            );
        }

        if (empty($createdReason)) {
            throw new TrackingException(
                'Invalid createdReason in ' . get_class($this)
            );
        }

        if (!empty($this->createdByUserId)) {
            throw new TrackingException(
                'Can not change createdByUserId in ' . get_class($this)
            );
        }

        $this->createdByUserId = $createdByUserId;

        if (!empty($this->createdDate)) {
            throw new TrackingException(
                'Can not change createdDate in ' . get_class($this)
            );
        }

        // ALWAYS STORE UTC
        $createdDateObject = new \DateTime(
            'now',
            new \DateTimeZone('UTC')
        );

        $this->createdDate = $createdDateObject->format(Trackable::DATE_FORMAT);
        $this->createdReason = $createdReason;
    }


    /**
     * @return void
     * @throws TrackingException
     */
    public function __clone()
    {
        throw new TrackingException(
            'Cloning of tracking objects is not supported in ' . get_class($this)
        );
    }

    /**
     * @param string $dateString
     * @param string $format
     *
     * @return \DateTime
     */
    public function __toDateTime(
        string $dateString,
        string $format = Trackable::DATE_FORMAT
    ) {
        $timezone = new \DateTimeZone('UTC');

        return \DateTime::createFromFormat(
            $format,
            $dateString,
            $timezone
        );
    }
}
