<?php

namespace Zrcms\CoreRedirectDoctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\CoreApplicationDoctrine\Entity\ContentEntity;
use Zrcms\CoreApplicationDoctrine\Entity\ContentEntityAbstract;
use Zrcms\CoreRedirect\Fields\FieldsRedirectVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_redirect_version",
 *     indexes={}
 * )
 */
class RedirectVersionEntity
    extends ContentEntityAbstract
    implements ContentEntity
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
     * if string, then applies to that site
     * if null, then applies to ALL sites
     *
     * @return string|null
     */
    public function getSiteCmsResourceId()
    {
        return $this->findProperty(
            FieldsRedirectVersion::SITE_CMS_RESOURCE_ID,
            null
        );
    }

    /**
     * @return string
     */
    public function getRequestPath(): string
    {
        return $this->findProperty(
            FieldsRedirectVersion::REQUEST_PATH,
            null
        );
    }

    /**
     * @return string
     */
    public function getRedirectPath(): string
    {
        return $this->findProperty(
            FieldsRedirectVersion::REDIRECT_PATH,
            null
        );
    }
}
