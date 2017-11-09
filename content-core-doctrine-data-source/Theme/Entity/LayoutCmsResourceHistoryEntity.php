<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Content\Exception\CmsResourceInvalid;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourceHistoryEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourceHistoryEntityAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_layout_resource_history",
 *     indexes={}
 * )
 */
class LayoutCmsResourceHistoryEntity
    extends CmsResourceHistoryEntityAbstract
    implements CmsResourceHistoryEntity
{
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
     * @var LayoutCmsResourceEntity
     *
     * @ORM\ManyToOne(targetEntity="LayoutCmsResourceEntity")
     * @ORM\JoinColumn(
     *     name="cmsResourceId",
     *     referencedColumnName="id",
     *     onDelete="SET NULL"
     * )
     */
    protected $cmsResourceEntity;

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
     * @var LayoutVersionEntity
     *
     * @ORM\ManyToOne(targetEntity="LayoutVersionEntity")
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
    protected $themeName;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @param string|null                               $id
     * @param string                                    $action
     * @param LayoutCmsResourceEntity|CmsResourceEntity $cmsResourceEntity
     * @param string                                    $publishedByUserId
     * @param string                                    $publishReason
     */
    public function __construct(
        $id,
        string $action,
        CmsResourceEntity $cmsResourceEntity,
        string $publishedByUserId,
        string $publishReason
    ) {
        $this->themeName = $cmsResourceEntity->getThemeName();
        $this->name = $cmsResourceEntity->getName();

        parent::__construct(
            $id,
            $action,
            $cmsResourceEntity,
            $publishedByUserId,
            $publishReason
        );
    }

    /**
     * @return string
     */
    public function getThemeName(): string
    {
        return $this->themeName;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param LayoutCmsResourceEntity $cmsResource
     *
     * @return void
     * @throws CmsResourceInvalid
     */
    protected function assertValidCmsResource($cmsResource)
    {
        if (!$cmsResource instanceof LayoutCmsResourceEntity) {
            throw new CmsResourceInvalid(
                'CmsResource must be instance of: ' . LayoutCmsResourceEntity::class
                . ' got: ' . var_export($cmsResource, true)
                . ' for: ' . get_class($this)
            );
        }
    }
}
