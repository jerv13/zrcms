<?php

namespace Zrcms\ContentRedirectDoctrineDataSource\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\ContentRedirect\Model\PropertiesRedirectCmsResource;
use Zrcms\ContentRedirect\Model\RedirectCmsResource;
use Zrcms\ContentRedirect\Model\RedirectCmsResourceAbstract;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntityTrait;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_redirect_resource",
 *     indexes={
 *        @ORM\Index(name="siteCmsResourceId", columns={"siteCmsResourceId"}),
 *        @ORM\Index(name="requestPath", columns={"requestPath"})
 *     }
 * )
 */
class RedirectCmsResourceEntity
    extends RedirectCmsResourceAbstract
    implements RedirectCmsResource, CmsResourceEntity
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
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $contentVersionId = null;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    protected $properties = [];

    /**
     * Date object was first created
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdDate;

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
    protected $requestPath;

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
            PropertiesRedirectCmsResource::ID
        );

        $this->contentVersionId = Param::getInt(
            $properties,
            PropertiesRedirectCmsResource::CONTENT_VERSION_ID
        );

        $this->siteCmsResourceId = Param::getString(
            $properties,
            PropertiesRedirectCmsResource::SITE_CMS_RESOURCE_ID
        );

        $this->requestPath = Param::getString(
            $properties,
            PropertiesRedirectCmsResource::REQUEST_PATH
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
     * @return string
     */
    public function getContentVersionId(): string
    {
        return $this->contentVersionId;
    }

    /**
     * @return string
     */
    public function getSiteCmsResourceId()
    {
        return $this->siteCmsResourceId;
    }

    /**
     * @return string
     */
    public function getRequestPath(): string
    {
        return $this->requestPath;
    }
}
