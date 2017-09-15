<?php

namespace Zrcms\ContentDoctrine\Entity;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Zrcms\Content\Model\PropertiesCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
trait CmsResourcePublishHistoryEntityTrait
{
    use TrackableEntityTrait;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $action;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $cmsResourceId = null;

    /**
     * @var ContainerCmsResourceEntity
     *
     * @ORM\ManyToOne(targetEntity="ContainerCmsResourceEntity")
     * @ORM\JoinColumn(
     *     name="cmsResourceId",
     *     referencedColumnName="id",
     *     onDelete="SET NULL"
     * )
     */
    protected $cmsResource;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    protected $cmsResourceProperties;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $contentVersionId = null;

    /**
     * @var ContainerVersionEntity
     *
     * @ORM\ManyToOne(targetEntity="ContainerVersionEntity")
     * @ORM\JoinColumn(
     *     name="contentVersionId",
     *     referencedColumnName="id",
     *     onDelete="SET NULL"
     * )
     */
    protected $contentVersion;

    /**
     * Date object was first created mapped to col createdDate
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="createdDate")
     */
    protected $createdDateObject;

    /**
     * User ID of creator
     *
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $createdByUserId;

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
