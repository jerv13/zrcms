<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResourceAbstract;
use Zrcms\ContentCore\Theme\Fields\FieldsLayoutCmsResource;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntityTrait;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_layout_resource",
 *     indexes={
 *        @ORM\Index(name="contentVersionId", columns={"contentVersionId"}),
 *        @ORM\Index(name="themeName", columns={"themeName"}),
 *        @ORM\Index(name="name", columns={"name"})
 *     }
 * )
 */
class LayoutCmsResourceEntity
    extends LayoutCmsResourceAbstract
    implements LayoutCmsResource, CmsResourceEntity
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
    protected $themeName;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;

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
        $this->setProperties($properties);

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
     * @return LayoutVersionEntity
     */
    public function getContentVersion()
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
     * @param array $properties
     *
     * @return void
     */
    public function updateProperties(
        array $properties
    ) {
        $this->id = Param::getInt(
            $properties,
            FieldsLayoutCmsResource::ID
        );

        $this->contentVersion = Param::get(
            $properties,
            FieldsLayoutCmsResource::CONTENT_VERSION
        );

        $this->published = Param::getBool(
            $properties,
            FieldsLayoutCmsResource::PUBLISHED
        );

        $this->themeName = Param::getString(
            $properties,
            FieldsLayoutCmsResource::THEME_NAME
        );

        $this->name = Param::getString(
            $properties,
            FieldsLayoutCmsResource::NAME
        );

        $this->properties = $properties;
    }
}
