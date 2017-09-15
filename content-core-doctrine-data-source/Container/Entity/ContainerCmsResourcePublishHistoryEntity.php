<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourcePublishHistoryEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourcePublishHistoryEntityAbstract;
use Zrcms\ContentDoctrine\Entity\CmsResourcePublishHistoryEntityTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_container_resource_publish_history",
 *     indexes={}
 * )
 */
class ContainerCmsResourcePublishHistoryEntity
    extends CmsResourcePublishHistoryEntityAbstract
    implements CmsResourcePublishHistoryEntity
{
    use CmsResourcePublishHistoryEntityTrait;

    /**
     * Short description of create reason
     *
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $createdReason;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $siteCmsResourceId;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $path;

    /**
     * @param string|null                                  $id
     * @param string                                       $action
     * @param ContainerCmsResourceEntity|CmsResourceEntity $cmsResource
     * @param string                                       $publishedByUserId
     * @param string                                       $publishReason
     */
    public function __construct(
        $id,
        string $action,
        CmsResourceEntity $cmsResource,
        string $publishedByUserId,
        string $publishReason
    ) {
        $this->siteCmsResourceId = $cmsResource->getSiteCmsResourceId();

        $this->path = $cmsResource->getPath();

        parent::__construct(
            $id,
            $action,
            $cmsResource,
            $publishedByUserId,
            $publishedByUserId
        );
    }

    /**
     * @return string
     */
    public function getSiteCmsResourceId(): string
    {
        return $this->siteCmsResourceId;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
