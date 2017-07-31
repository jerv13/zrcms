<?php

namespace Zrcms\ContentDoctrine\Entity;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Zrcms\Content\Model\PropertiesCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
trait CmsResourceEntityTrait
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return (string)$this->id;
    }

    /**
     * @param array $properties
     *
     * @return void
     */
    public function updateProperties(
        array $properties
    ) {
        $this->properties = $properties;
    }


    /**
     * @return void
     *
     * @ORM\PrePersist
     */
    public function assertHasTrackingData()
    {
        // Expects class to implement Trackable
        parent::assertHasTrackingData();
    }

    /**
     * @return void
     *
     * @ORM\PostPersist
     */
    public function postPersist(LifecycleEventArgs $event)
    {
        $this->properties[PropertiesCmsResource::ID] = $this->id;
    }
}
