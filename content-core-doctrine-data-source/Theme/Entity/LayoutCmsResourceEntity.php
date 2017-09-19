<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Entity;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\ContentCore\Theme\Fields\FieldsLayoutCmsResource;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntityAbstract;
use Zrcms\ContentDoctrine\Entity\ContentEntity;
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
    extends CmsResourceEntityAbstract
    implements CmsResourceEntity
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
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $published = true;

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
     * @param int|null                          $id
     * @param bool                              $published
     * @param LayoutVersionEntity|ContentEntity $contentEntity
     * @param array                             $properties
     * @param string                            $createdByUserId
     * @param string                            $createdReason
     */
    public function __construct(
        $id,
        bool $published,
        ContentEntity $contentEntity,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        $this->setProperties($properties);

        parent::__construct(
            $id,
            $published,
            $contentEntity,
            $properties,
            $createdByUserId,
            $createdReason
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
     * @param array $properties
     *
     * @return void
     */
    public function setProperties(
        array $properties
    ) {
        Param::assertHas(
            $properties,
            FieldsLayoutCmsResource::THEME_NAME,
            PropertyMissingException::buildThrower(
                FieldsLayoutCmsResource::THEME_NAME,
                $properties,
                get_class($this)
            )
        );

        $this->themeName = Param::getString(
            $properties,
            FieldsLayoutCmsResource::THEME_NAME,
            ''
        );

        Param::assertHas(
            $properties,
            FieldsLayoutCmsResource::NAME,
            PropertyMissingException::buildThrower(
                FieldsLayoutCmsResource::NAME,
                $properties,
                get_class($this)
            )
        );

        $this->name = Param::getString(
            $properties,
            FieldsLayoutCmsResource::NAME,
            ''
        );

        parent::setProperties($properties);
    }

    /**
     * @return void
     *
     * @ORM\PostPersist
     */
    public function postPersist(LifecycleEventArgs $event)
    {
        $this->properties[FieldsLayoutCmsResource::THEME_NAME] = $this->themeName;
        $this->properties[FieldsLayoutCmsResource::NAME] = $this->name;
    }
}
