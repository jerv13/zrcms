<?php

namespace Zrcms\ContentDoctrine\Entity;

use Zrcms\Content\Exception\TrackingException;
use Zrcms\Content\Model\Trackable;
use Zrcms\ContentDoctrine\Exception\MissingCreatedDateObjectProperty;

/**
 * @see \Zrcms\Content\Model\TrackableTrait
 *
 * @author James Jervis - https://github.com/jerv13
 */
trait TrackableEntityTrait
{
    /**
     * @return string
     * @throws TrackingException
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
            throw new TrackingException(
                'Value not set for createdDate in ' . get_class($this)
            );
        }

        return $this->createdDateObject->format(Trackable::DATE_FORMAT);
    }
}
