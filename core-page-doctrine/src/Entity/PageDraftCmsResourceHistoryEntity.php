<?php

namespace Zrcms\CorePageDoctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Core\Exception\CmsResourceInvalid;
use Zrcms\CoreApplicationDoctrine\Entity\CmsResourceEntity;
use Zrcms\CoreApplicationDoctrine\Entity\CmsResourceHistoryEntity;
use Zrcms\CoreApplicationDoctrine\Entity\CmsResourceHistoryEntityAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_page_draft_resource_history",
 *     indexes={}
 * )
 */
class PageDraftCmsResourceHistoryEntity extends CmsResourceHistoryEntityAbstract implements CmsResourceHistoryEntity
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="string")
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
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cmsResourceId = null;

    /**
     * @var PageDraftCmsResourceEntity
     *
     * @ORM\ManyToOne(targetEntity="PageDraftCmsResourceEntity")
     * @ORM\JoinColumn(
     *     name="cmsResourceId",
     *     referencedColumnName="id",
     *     onDelete="SET NULL"
     * )
     */
    protected $cmsResourceEntity;

    /**
     * @var int
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $contentVersionId = null;

    /**
     * @var PageVersionEntity
     *
     * @ORM\ManyToOne(targetEntity="PageVersionEntity")
     * @ORM\JoinColumn(
     *     name="contentVersionId",
     *     referencedColumnName="id",
     *     onDelete="SET NULL"
     * )
     */
    protected $contentVersion;

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
     * Date object was first created mapped to col createdDate
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="createdDate")
     */
    protected $createdDateObject;

    /**
     * @param null|string                                  $id
     * @param string                                       $action
     * @param PageDraftCmsResourceEntity|CmsResourceEntity $cmsResourceEntity
     * @param string                                       $publishedByUserId
     * @param string                                       $publishReason
     * @param string|null                                  $publishDate
     */
    public function __construct(
        $id,
        string $action,
        CmsResourceEntity $cmsResourceEntity,
        string $publishedByUserId,
        string $publishReason,
        $publishDate = null
    ) {
        parent::__construct(
            $id,
            $action,
            $cmsResourceEntity,
            $publishedByUserId,
            $publishedByUserId,
            $publishDate
        );
    }

    /**
     * @param PageDraftCmsResourceEntity $cmsResource
     *
     * @return void
     * @throws CmsResourceInvalid
     */
    protected function assertValidCmsResource($cmsResource)
    {
        if (!$cmsResource instanceof PageDraftCmsResourceEntity) {
            throw new CmsResourceInvalid(
                'CmsResource must be instance of: ' . PageDraftCmsResourceEntity::class
                . ' got: ' . var_export($cmsResource, true)
                . ' for: ' . get_class($this)
            );
        }
    }
}
