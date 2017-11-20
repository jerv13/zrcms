<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Content\Exception\ContentVersionInvalid;
use Zrcms\ContentCore\Page\Fields\FieldsPageVersion;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntityAbstract;
use Zrcms\ContentDoctrine\Entity\ContentEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_page_draft_resource",
 *     indexes={
 *        @ORM\Index(name="contentVersionId", columns={"contentVersionId"}),
 *        @ORM\Index(name="siteCmsResourceId", columns={"siteCmsResourceId"}),
 *        @ORM\Index(name="pageCmsResourceId", columns={"pageCmsResourceId"})
 *     }
 * )
 */
class PageDraftCmsResourceEntity
    extends CmsResourceEntityAbstract
    implements CmsResourceEntity
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $published = true;

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
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $modifiedByUserId;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $modifiedReason;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="modifiedDateDate")
     */
    protected $modifiedDateObject;

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
    protected $pageCmsResourceId;

    /**
     * @param null|string                     $id
     * @param bool                            $published
     * @param PageVersionEntity|ContentEntity $contentVersion
     * @param string                          $createdByUserId
     * @param string                          $createdReason
     * @param string|null                     $createdDate
     */
    public function __construct(
        $id,
        bool $published,
        ContentEntity $contentVersion,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        parent::__construct(
            $id,
            $published,
            $contentVersion,
            $createdByUserId,
            $createdReason,
            $createdDate
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
    public function getPageCmsResourceId(): string
    {
        return $this->pageCmsResourceId;
    }

    /**
     * @param PageVersionEntity|ContentEntity $contentVersion
     * @param string                          $modifiedByUserId
     * @param string                          $modifiedReason
     * @param string|null                     $modifiedDate
     *
     * @return void
     */
    public function setContentVersion(
        ContentEntity $contentVersion,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ) {
        $this->siteCmsResourceId = $contentVersion->getSiteCmsResourceId();
        $this->pageCmsResourceId = $contentVersion->getProperty(FieldsPageVersion::PAGE_CMS_RESOURCE_ID);

        parent::setContentVersion(
            $contentVersion,
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
        );
    }

    /**
     * @param PageVersionEntity $contentVersion
     *
     * @return void
     * @throws ContentVersionInvalid
     */
    protected function assertValidContentVersion($contentVersion)
    {
        if (!$contentVersion instanceof PageVersionEntity) {
            throw new ContentVersionInvalid(
                'ContentVersion must be instance of: ' . PageVersionEntity::class
                . ' got: ' . var_export($contentVersion, true)
                . ' for: ' . get_class($this)
            );
        }

        if (empty($contentVersion->getSiteCmsResourceId())) {
            throw new ContentVersionInvalid(
                'SiteCmsResourceId can not be empty'
            );
        }

        if (empty($contentVersion->getProperty(FieldsPageVersion::PAGE_CMS_RESOURCE_ID))) {
            throw new ContentVersionInvalid(
                'PageCmsResourceId can not be empty'
            );
        }
    }
}
