<?php

namespace Zrcms\ContentDoctrine\Entity;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Zrcms\Content\Model\PropertiesCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
trait CmsResourcePublishHistoryEntityTrait
{
    use TrackableEntityTrait;

    /**
     * @return string
     */
    public function getId(): string
    {
        return (string)$this->id;
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
        $this->properties[PropertiesCmsResource::CONTENT_VERSION] = $this->contentVersion;
        $this->properties[PropertiesCmsResource::PUBLISHED] = $this->published;
    }
}
