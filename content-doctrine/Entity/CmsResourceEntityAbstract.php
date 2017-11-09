<?php

namespace Zrcms\ContentDoctrine\Entity;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class CmsResourceEntityAbstract
{
    use TrackableModifyEntityTrait;

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
    protected $contentVersion;

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
     * @var string
     */
    protected $modifiedByUserId;

    /**
     * @var string
     */
    protected $modifiedReason;

    /**
     * @var \DateTime
     */
    protected $modifiedDateObject;

    /**
     * @param string|null   $id
     * @param bool          $published
     * @param ContentEntity $contentVersion
     * @param string        $createdByUserId
     * @param string        $createdReason
     * @param string|null   $createdDate
     */
    public function __construct(
        $id,
        bool $published,
        ContentEntity $contentVersion,
        string $createdByUserId,
        string $createdReason,
        string $createdDate = null
    ) {
        $this->id = $id;

        $this->setCreatedData(
            $createdByUserId,
            $createdReason,
            $createdDate
        );

        $this->update(
            $published,
            $contentVersion,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }

    /**
     * @param bool          $published
     * @param ContentEntity $contentVersion
     * @param string        $modifiedByUserId
     * @param string        $modifiedReason
     * @param string|null   $modifiedDate
     *
     * @return void
     */
    public function update(
        bool $published,
        ContentEntity $contentVersion,
        string $modifiedByUserId,
        string $modifiedReason,
        string $modifiedDate = null
    ) {
        $this->published = $published;
        $this->contentVersion = $contentVersion;

        $this->setModifiedData(
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
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
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * @return ContentEntity
     */
    public function getContentEntity()
    {
        return $this->contentVersion;
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
        $this->assertHasModifiedData();
    }
}
