<?php

namespace Zrcms\ContentRedirectDoctrineDataSource\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourceHistoryEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourceHistoryEntityAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_redirect_resource_history",
 *     indexes={}
 * )
 */
class RedirectCmsResourceHistoryEntity
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
     * @var RedirectCmsResourceEntity
     *
     * @ORM\ManyToOne(targetEntity="RedirectCmsResourceEntity")
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
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $contentVersionId = null;

    /**
     * @var RedirectVersionEntity
     *
     * @ORM\ManyToOne(targetEntity="RedirectVersionEntity")
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
     * @param null|string                                 $id
     * @param string                                      $action
     * @param RedirectCmsResourceEntity|CmsResourceEntity $cmsResourceEntity
     * @param string                                      $publishedByUserId
     * @param string                                      $publishReason
     * @param string|null                                 $publishDate
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
            $publishReason,
            $publishDate
        );
    }
}
