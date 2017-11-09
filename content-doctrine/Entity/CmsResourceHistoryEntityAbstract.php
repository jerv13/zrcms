<?php

namespace Zrcms\ContentDoctrine\Entity;

use Zrcms\Content\Exception\CmsResourceInvalid;
use Zrcms\Content\Model\ImmutableTrait;

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
     * @param string|null       $id
     * @param string            $action
     * @param CmsResourceEntity $cmsResourceEntity
     * @param string            $publishedByUserId
     * @param string            $publishReason
     */
    public function __construct(
        $id,
        string $action,
        CmsResourceEntity $cmsResourceEntity,
        string $publishedByUserId,
        string $publishReason
    ) {
        // Enforce immutability
        if (!$this->isNew()) {
            return;
        }
        $this->new = false;

        $this->id = $id;

        $this->action = $action;

        $this->assertValidCmsResource($cmsResourceEntity);

        $this->cmsResourceEntity = $cmsResourceEntity;

        $this->contentVersion = $cmsResourceEntity->getContentVersion();

        $this->setCreatedData(
            $publishedByUserId,
            $publishReason
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
     * @return ContentEntity
     */
    public function getContentVersion()
    {
        return $this->contentVersion;
    }

    /**
     * @return CmsResourceEntity
     */
    public function getCmsResource()
    {
        return $this->cmsResourceEntity;
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
}
