<?php

namespace Zrcms\CoreApplicationDoctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Zrcms\Core\Model\ImmutableTrait;
use Zrcms\Core\Model\PropertiesTrait;
use Zrcms\CoreApplication\Api\GetGuidV4;

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

        if (empty($id)) {
            $id = GetGuidV4::invoke();
        }

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
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
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
