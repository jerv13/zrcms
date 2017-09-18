<?php

namespace Zrcms\ContentDoctrine\Entity;

use Zrcms\Content\Exception\ContentVersionInvalid;
use Zrcms\Content\Model\ImmutableTrait;
use Zrcms\Content\Model\PropertiesTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsResourceEntityAbstract
{
    use ImmutableTrait;
    use PropertiesTrait;
    use TrackableEntityTrait;

    /**
     * @var null|int
     */
    protected $id = null;

    /**
     * @var bool
     */
    protected $published;

    /**
     * @var ContentEntity
     */
    protected $contentEntity;

    /**
     * @var array
     */
    protected $properties = [];

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
     * @param int|null      $id
     * @param ContentEntity $contentEntity
     * @param bool          $published
     * @param array         $properties
     * @param string        $createdByUserId
     * @param string        $createdReason
     */
    public function __construct(
        $id,
        ContentEntity $contentEntity,
        bool $published,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        // Enforce immutability
        if (!$this->isNew()) {
            return;
        }
        $this->new = false;

        $this->id = $id;

        $this->published = $published;

        $this->contentEntity = $contentEntity;

        $this->assertValidContentVersion($contentEntity);

        $this->setProperties($properties);

        $this->setCreatedData(
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return (string)$this->id;
    }

    /**
     * @return ContentEntity
     */
    public function getContentEntity()
    {
        return $this->contentEntity;
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * Sync array of properties to object properties
     *
     * @param array $properties
     *
     * @return void
     */
    public function setProperties(
        array $properties
    ) {
        $this->properties = $properties;
    }

    /**
     * @param ContentEntity $contentEntity
     *
     * @return void
     * @throws ContentVersionInvalid
     */
    protected function assertValidContentVersion($contentEntity)
    {
        if (!$contentEntity instanceof ContentEntity) {
            throw new ContentVersionInvalid(
                'ContentEntity must be instance of: ' . ContentEntity::class
                . ' got: ' . var_export($contentEntity, true)
                . ' for: ' . get_class($this)
            );
        }
    }
}
