<?php

namespace Zrcms\ContentDoctrine\Entity;

use Zrcms\Content\Exception\TrackingInvalid;
use Zrcms\Content\Model\Trackable;
use Zrcms\Content\Model\TrackableModifyTrait;
use Zrcms\ContentDoctrine\Exception\MissingCreatedDateObjectProperty;
use Zrcms\ContentDoctrine\Exception\MissingModifiedDateObjectProperty;

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

        return $this->createdDateObject->format(Trackable::DATE_FORMAT);
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

        return $this->modifiedDateObject->format(Trackable::DATE_FORMAT);
    }
}
