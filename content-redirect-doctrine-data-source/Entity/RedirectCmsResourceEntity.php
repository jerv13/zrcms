<?php

namespace Zrcms\ContentRedirectDoctrineDataSource\Entity;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntityAbstract;
use Zrcms\ContentDoctrine\Entity\ContentEntity;
use Zrcms\ContentRedirect\Fields\FieldsRedirectCmsResource;
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
     * @var RedirectVersionEntity
     *
     * @ORM\ManyToOne(targetEntity="RedirectVersionEntity")
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
     * @ORM\Column(type="string", nullable=true)
     */
    protected $siteCmsResourceId;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $requestPath;

    /**
     * @param int|null                            $id
     * @param bool                                $published
     * @param RedirectVersionEntity|ContentEntity $contentEntity
     * @param array                               $properties
     * @param string                              $createdByUserId
     * @param string                              $createdReason
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
            FieldsRedirectCmsResource::SITE_CMS_RESOURCE_ID,
            PropertyMissingException::buildThrower(
                FieldsRedirectCmsResource::SITE_CMS_RESOURCE_ID,
                $properties,
                get_class($this)
            )
        );

        $this->siteCmsResourceId = Param::getString(
            $properties,
            FieldsRedirectCmsResource::SITE_CMS_RESOURCE_ID,
            ''
        );

        Param::assertHas(
            $properties,
            FieldsRedirectCmsResource::REQUEST_PATH,
            PropertyMissingException::buildThrower(
                FieldsRedirectCmsResource::REQUEST_PATH,
                $properties,
                get_class($this)
            )
        );

        $this->requestPath = Param::getString(
            $properties,
            FieldsRedirectCmsResource::REQUEST_PATH,
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
        $this->properties[FieldsRedirectCmsResource::SITE_CMS_RESOURCE_ID] = $this->siteCmsResourceId;
        $this->properties[FieldsRedirectCmsResource::REQUEST_PATH] = $this->requestPath;
    }
}
