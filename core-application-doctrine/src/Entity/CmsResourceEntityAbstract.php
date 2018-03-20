<?php

namespace Zrcms\CoreApplicationDoctrine\Entity;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Zrcms\Core\Exception\ContentVersionInvalid;
use Zrcms\CoreApplication\Api\GetGuidV4;

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
     *
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    public function __construct(
        $id,
        bool $published,
        ContentEntity $contentVersion,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        if (empty($id)) {
            $id = GetGuidV4::invoke();
        }

        $this->id = $id;

        $this->setContentVersion(
            $contentVersion,
            $createdByUserId,
            $createdReason,
            $createdDate
        );

        $this->setPublished(
            $published,
            $createdByUserId,
            $createdReason,
            $createdDate
        );

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
        return (string)$this->id;
    }

    /**
     * @param bool   $published
     * @param string $modifiedByUserId
     * @param string $modifiedReason
     * @param string $modifiedDate
     *
     * @return void
     */
    public function setPublished(
        bool $published,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ) {
        $this->setModifiedData(
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
        );

        $this->published = $published;
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * @return null|string
     */
    public function getContentVersionId()
    {
        if (!empty($this->getContentVersion())) {
            return $this->getContentVersion()->getId();
        }

        return null;
    }

    /**
     * @return ContentEntity
     */
    public function getContentVersion()
    {
        return $this->contentVersion;
    }

    /**
     * @param ContentEntity $contentVersion
     * @param string        $modifiedByUserId
     * @param string        $modifiedReason
     * @param string|null   $modifiedDate
     *
     * @return void
     */
    public function setContentVersion(
        ContentEntity $contentVersion,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ) {
        $this->assertValidContentVersion($contentVersion);

        $this->setModifiedData(
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
        );

        $this->contentVersion = $contentVersion;
    }

    /**
     * @param $contentVersion
     *
     * @return void
     * @throws ContentVersionInvalid
     */
    protected function assertValidContentVersion($contentVersion)
    {
        if (!$contentVersion instanceof ContentEntity) {
            throw new ContentVersionInvalid(
                'ContentVersion must be instance of: ' . ContentEntity::class
                . ' got: ' . var_export($contentVersion, true)
                . ' for: ' . get_class($this)
            );
        }
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
