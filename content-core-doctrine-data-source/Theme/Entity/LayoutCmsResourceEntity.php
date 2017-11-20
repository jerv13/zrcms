<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Content\Exception\ContentVersionInvalid;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntityAbstract;
use Zrcms\ContentDoctrine\Entity\ContentEntity;

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
    protected $themeName;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $html;

    /**
     * @param null|string                       $id
     * @param bool                              $published
     * @param LayoutVersionEntity|ContentEntity $contentVersion
     * @param string                            $createdByUserId
     * @param string                            $createdReason
     * @param string|null                       $createdDate
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
     * @return string
     */
    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * @param LayoutVersionEntity|ContentEntity $contentVersion
     * @param string                            $modifiedByUserId
     * @param string                            $modifiedReason
     * @param string|null                       $modifiedDate
     *
     * @return void
     */
    public function setContentVersion(
        ContentEntity $contentVersion,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ) {
        $this->themeName = $contentVersion->getThemeName();
        $this->name = $contentVersion->getName();
        $this->html = $contentVersion->getHtml();

        parent::setContentVersion(
            $contentVersion,
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
        );
    }

    /**
     * @param LayoutVersionEntity $contentVersion
     *
     * @return void
     * @throws ContentVersionInvalid
     */
    protected function assertValidContentVersion($contentVersion)
    {
        if (!$contentVersion instanceof LayoutVersionEntity) {
            throw new ContentVersionInvalid(
                'ContentVersion must be instance of: ' . LayoutVersionEntity::class
                . ' got: ' . var_export($contentVersion, true)
                . ' for: ' . get_class($this)
            );
        }

        if (empty($contentVersion->getThemeName())) {
            throw new ContentVersionInvalid(
                'ThemeName can not be empty'
            );
        }

        if (empty($contentVersion->getName())) {
            throw new ContentVersionInvalid(
                'Name can not be empty'
            );
        }
    }
}
