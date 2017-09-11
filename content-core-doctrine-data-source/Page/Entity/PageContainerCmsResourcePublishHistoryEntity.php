<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\Content\Model\PropertiesCmsResourcePublishHistory;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResourcePublishHistory;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResourcePublishHistoryAbstract;
use Zrcms\ContentCore\Page\Model\PropertiesPageContainerCmsResource;
use Zrcms\ContentDoctrine\Entity\CmsResourcePublishHistoryEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourcePublishHistoryEntityTrait;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_page_container_resource_publish_history",
 *     indexes={}
 * )
 */
class PageContainerCmsResourcePublishHistoryEntity
    extends PageContainerCmsResourcePublishHistoryAbstract
    implements PageContainerCmsResourcePublishHistory, CmsResourcePublishHistoryEntity
{
    use CmsResourcePublishHistoryEntityTrait;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var PageContainerVersionEntity
     *
     * @ORM\OneToOne(targetEntity="PageContainerVersionEntity")
     * @ORM\JoinColumn(
     *     name="contentVersionId",
     *     referencedColumnName="id",
     *     onDelete="SET NULL"
     * )
     */
    protected $contentVersion;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $contentVersionId = null;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $published = true;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    protected $properties = [];

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
    protected $siteCmsResourceId;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $path;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $cmsResourceId;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $action;

    /**
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        $this->id = Param::getInt(
            $properties,
            PropertiesPageContainerCmsResource::ID
        );

        $this->contentVersion = Param::get(
            $properties,
            PropertiesPageContainerCmsResource::CONTENT_VERSION
        );

        $this->published = Param::getBool(
            $properties,
            PropertiesPageContainerCmsResource::PUBLISHED
        );

        $this->siteCmsResourceId = Param::getInt(
            $properties,
            PropertiesPageContainerCmsResource::SITE_CMS_RESOURCE_ID
        );

        $this->path = Param::getString(
            $properties,
            PropertiesPageContainerCmsResource::PATH
        );

        $this->cmsResourceId = Param::getString(
            $properties,
            PropertiesCmsResourcePublishHistory::CMS_RESOURCE_ID
        );

        $this->action = Param::getString(
            $properties,
            PropertiesCmsResourcePublishHistory::ACTION
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
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
     * @return ContentVersion
     */
    public function getContentVersion(): ContentVersion
    {
        return $this->contentVersion;
    }

    /**
     * @return string
     */
    public function getContentVersionId(): string
    {
        return (string)$this->contentVersionId;
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * @return string
     */
    public function getCmsResourceId(): string
    {
        return $this->cmsResourceId;
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
    public function getPath(): string
    {
        return $this->path;
    }
}
