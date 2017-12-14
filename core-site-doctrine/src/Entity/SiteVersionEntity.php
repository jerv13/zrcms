<?php

namespace Zrcms\CoreSiteDoctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\CoreSite\Fields\FieldsSiteVersion;
use Zrcms\CoreApplicationDoctrine\Entity\ContentEntity;
use Zrcms\CoreApplicationDoctrine\Entity\ContentEntityAbstract;
use Zrcms\Locale\Api\DefaultLocal;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_site_version",
 *     indexes={}
 * )
 */
class SiteVersionEntity extends ContentEntityAbstract implements ContentEntity
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

    /**
     *
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    protected $properties = [];

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
     * @param null|string $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        parent::__construct(
            $id,
            $properties,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->findProperty(
            FieldsSiteVersion::HOST,
            ''
        );
    }

    /**
     * @return string
     */
    public function getThemeName(): string
    {
        return $this->findProperty(
            FieldsSiteVersion::THEME_NAME,
            ''
        );
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->findProperty(
            FieldsSiteVersion::LOCALE,
            DefaultLocal::get()
        );
    }
}
