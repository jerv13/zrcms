<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Site\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Site\Model\PropertiesSiteCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceAbstract;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntityTrait;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_site_resource",
 *     indexes={
 *        @ORM\Index(name="contentVersionId", columns={"contentVersionId"}),
 *        @ORM\Index(name="host", columns={"host"})
 *     }
 * )
 */
class SiteCmsResourceEntity
    extends SiteCmsResourceAbstract
    implements SiteCmsResource, CmsResourceEntity
{
    use CmsResourceEntityTrait;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var SiteVersionEntity
     *
     * @ORM\OneToOne(targetEntity="SiteVersionEntity")
     * @ORM\JoinColumn(
     *     name="contentVersionId",
     *     referencedColumnName="id",
     *     onDelete="SET NULL"
     * )
     */
    protected $contentVersion;

    /**
     * @var string
     *
     * @ORM\Column(type="integer")
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
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    protected $host;

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
        $this->updateProperties($properties);

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
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param array $properties
     *
     * @return void
     */
    public function updateProperties(
        array $properties
    ) {
        $this->id = Param::getInt(
            $properties,
            PropertiesSiteCmsResource::ID
        );

        $this->contentVersion = Param::get(
            $properties,
            PropertiesSiteCmsResource::CONTENT_VERSION
        );

        $this->published = Param::getBool(
            $properties,
            PropertiesSiteCmsResource::PUBLISHED
        );

        Param::assertHas(
            $properties,
            PropertiesSiteCmsResource::HOST
        );

        $this->host = Param::getString(
            $properties,
            PropertiesSiteCmsResource::HOST
        );

        $this->properties = $properties;
    }
}
