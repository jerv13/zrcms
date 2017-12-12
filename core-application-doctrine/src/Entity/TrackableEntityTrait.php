<?php

namespace Zrcms\CoreApplicationDoctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Core\Exception\TrackingInvalid;
use Zrcms\Core\Model\Trackable;
use Zrcms\Core\Model\TrackableTrait;
use Zrcms\CoreApplicationDoctrine\Exception\MissingCreatedDateObjectProperty;

/**
 * @see    \Zrcms\Core\Model\TrackableTrait
 *
 * @author James Jervis - https://github.com/jerv13
 */
trait TrackableEntityTrait
{
    use TrackableTrait;

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
}
