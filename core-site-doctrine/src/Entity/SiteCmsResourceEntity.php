<?php

namespace Zrcms\CoreSiteDoctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Core\Exception\ContentVersionInvalid;
use Zrcms\CoreApplicationDoctrine\Entity\CmsResourceEntity;
use Zrcms\CoreApplicationDoctrine\Entity\CmsResourceEntityAbstract;
use Zrcms\CoreApplicationDoctrine\Entity\ContentEntity;

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
class SiteCmsResourceEntity extends CmsResourceEntityAbstract implements CmsResourceEntity
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
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $contentVersionId = null;

    /**
     * @var SiteVersionEntity
     *
     * @ORM\ManyToOne(targetEntity="SiteVersionEntity")
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
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    protected $host;

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
    protected $locale;

    /**
     * @param null|string                     $id
     * @param bool                            $published
     * @param SiteVersionEntity|ContentEntity $contentVersion
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
     * @param SiteVersionEntity|ContentEntity $contentVersion
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
        $this->host = $contentVersion->getHost();
        $this->themeName = $contentVersion->getThemeName();
        $this->locale = $contentVersion->getLocale();

        parent::setContentVersion(
            $contentVersion,
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
        );
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
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
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param SiteVersionEntity $contentVersion
     *
     * @return void
     * @throws ContentVersionInvalid
     */
    protected function assertValidContentVersion($contentVersion)
    {
        if (!$contentVersion instanceof SiteVersionEntity) {
            throw new ContentVersionInvalid(
                'ContentVersion must be instance of: ' . SiteVersionEntity::class
                . ' got: ' . var_export($contentVersion, true)
                . ' for: ' . get_class($this)
            );
        }

        if (empty($contentVersion->getHost())) {
            throw new ContentVersionInvalid(
                'Host can not be empty'
            );
        }

        if (empty($contentVersion->getThemeName())) {
            throw new ContentVersionInvalid(
                'ThemeName can not be empty'
            );
        }

        if (empty($contentVersion->getLocale())) {
            throw new ContentVersionInvalid(
                'Locale can not be empty'
            );
        }
    }
}
