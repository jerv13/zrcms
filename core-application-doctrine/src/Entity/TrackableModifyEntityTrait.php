<?php

namespace Zrcms\CoreApplicationDoctrine\Entity;

use Zrcms\Core\Exception\TrackingInvalid;
use Zrcms\Core\Model\Trackable;
use Zrcms\Core\Model\TrackableModifyTrait;
use Zrcms\CoreApplicationDoctrine\Exception\MissingCreatedDateObjectProperty;
use Zrcms\CoreApplicationDoctrine\Exception\MissingModifiedDateObjectProperty;

/**
 * @author James Jervis - https://github.com/jerv13
 */
trait TrackableModifyEntityTrait
{
    use TrackableModifyTrait;

    /**
     * @return string
     * @throws TrackingInvalid
     * @throws MissingCreatedDateObjectProperty
     */
    public function getCreatedDate(): string
    {
        if (!property_exists($this, 'createdDateObject')) {
            throw new MissingCreatedDateObjectProperty(
                'Entity must have a createdDateObject that maps to createdDate'
            );
        }

        if (empty($this->createdDateObject) || !$this->createdDateObject instanceof \DateTime) {
            throw new TrackingInvalid(
                'Value not set for createdDate in ' . get_class($this)
            );
        }

        // ALWAYS RETURN UTC
        $timezone = new \DateTimeZone('UTC');

        // Clone to prevent changes
        $dateTime =  clone($this->createdDateObject);
        $dateTime->setTimezone($timezone);

        return $dateTime->format(Trackable::DATE_FORMAT);
    }

    /**
     * @return string
     * @throws TrackingInvalid
     * @throws MissingModifiedDateObjectProperty
     */
    public function getModifiedDate(): string
    {
        if (!property_exists($this, 'modifiedDateObject')) {
            throw new MissingModifiedDateObjectProperty(
                'Entity must have a modifiedDateObject that maps to modifiedDate'
            );
        }

        if (empty($this->modifiedDateObject) || !$this->modifiedDateObject instanceof \DateTime) {
            throw new TrackingInvalid(
                'Value not set for modifiedDate in ' . get_class($this)
            );
        }

        // ALWAYS RETURN UTC
        $timezone = new \DateTimeZone('UTC');

        // Clone to prevent changes
        $dateTime =  clone($this->modifiedDateObject);
        $dateTime->setTimezone($timezone);

        return $dateTime->format(Trackable::DATE_FORMAT);
    }
}
