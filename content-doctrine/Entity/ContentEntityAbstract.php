<?php

namespace Zrcms\ContentDoctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Zrcms\Content\Model\ImmutableTrait;
use Zrcms\Content\Model\PropertiesTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ContentEntityAbstract
{
    use ImmutableTrait;
    use PropertiesTrait;
    use TrackableEntityTrait;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * @var string
     */
    protected $createdByUserId;

    /**
     * @var string
     */
    protected $createdReason;

    /**
     * @var \DateTime
     */
    protected $createdDateObject;

    /**
     * @param string|null $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        // Enforce immutability
        if (!$this->isNew()) {
            return;
        }
        $this->new = false;

        $this->id = $id;
        $this->properties = $properties;

        $this->setCreatedData(
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     *
     * @return void
     *
     * @ORM\PrePersist
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $this->assertHasCreatedData();
    }
}
