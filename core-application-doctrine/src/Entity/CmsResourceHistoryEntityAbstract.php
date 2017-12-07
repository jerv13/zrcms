<?php

namespace Zrcms\CoreApplicationDoctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Zrcms\Core\Exception\CmsResourceInvalid;
use Zrcms\Core\Model\ImmutableTrait;
use Zrcms\CoreApplication\Api\GetGuidV4;

/**
 * A history record of the state of
 *
 * @author James Jervis - https://github.com/jerv13
 */
abstract class CmsResourceHistoryEntityAbstract
{
    use ImmutableTrait;
    use TrackableEntityTrait;

    /**
     * @var null|string
     */
    protected $id = null;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var CmsResourceEntity
     */
    protected $cmsResourceEntity;

    /**
     * @var ContentEntity
     */
    protected $contentVersion;

    /**
     * @param string|null $id
     * @param string $action
     * @param CmsResourceEntity $cmsResourceEntity
     * @param string $publishedByUserId
     * @param string $publishReason
     * @param string|null $publishDate
     */
    public function __construct(
        $id,
        string $action,
        CmsResourceEntity $cmsResourceEntity,
        string $publishedByUserId,
        string $publishReason,
        $publishDate = null
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

        $this->action = $action;

        $this->assertValidCmsResource($cmsResourceEntity);

        $this->cmsResourceEntity = $cmsResourceEntity;

        $this->contentVersion = $cmsResourceEntity->getContentVersion();

        $this->setCreatedData(
            $publishedByUserId,
            $publishReason,
            $publishDate
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
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getCmsResourceId(): string
    {
        if (!empty($this->getCmsResource())) {
            return $this->getCmsResource()->getId();
        }

        return '';
    }

    /**
     * @return CmsResourceEntity
     */
    public function getCmsResource()
    {
        return $this->cmsResourceEntity;
    }

    /**
     * @return string
     */
    public function getContentVersionId(): string
    {
        if (!empty($this->getContentVersion())) {
            return $this->getContentVersion()->getId();
        }

        return '';
    }

    /**
     * @return ContentEntity
     */
    public function getContentVersion()
    {
        return $this->contentVersion;
    }

    /**
     * @param CmsResourceEntity $cmsResource
     *
     * @return void
     * @throws CmsResourceInvalid
     */
    protected function assertValidCmsResource($cmsResource)
    {
        if (!$cmsResource instanceof CmsResourceEntity) {
            throw new CmsResourceInvalid(
                'CmsResource must be instance of: ' . CmsResourceEntity::class
                . ' got: ' . var_export($cmsResource, true)
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
    }
}
