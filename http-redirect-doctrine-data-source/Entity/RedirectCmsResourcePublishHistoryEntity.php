<?php

namespace Zrcms\HttpRedirectDoctrineDataSource\Redirect\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Content\Model\PropertiesCmsResourcePublishHistory;
use Zrcms\HttpRedirect\Redirect\Model\PropertiesRedirectCmsResource;
use Zrcms\HttpRedirect\Redirect\Model\RedirectCmsResourcePublishHistory;
use Zrcms\HttpRedirect\Redirect\Model\RedirectCmsResourcePublishHistoryAbstract;
use Zrcms\ContentDoctrine\Entity\CmsResourcePublishHistoryEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourcePublishHistoryEntityTrait;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_redirect_resource_publish_history",
 *     indexes={}
 * )
 */
class RedirectCmsResourcePublishHistoryEntity
    extends RedirectCmsResourcePublishHistoryAbstract
    implements RedirectCmsResourcePublishHistory, CmsResourcePublishHistoryEntity
{
    use CmsResourcePublishHistoryEntityTrait;

    /**
     * @var string
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
    protected $action;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
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
        $this->id = Param::getInt(
            $properties,
            PropertiesRedirectCmsResource::ID
        );

        $this->contentVersionId = Param::getInt(
            $properties,
            PropertiesRedirectCmsResource::CONTENT_VERSION_ID
        );

        $this->host = Param::getString(
            $properties,
            PropertiesRedirectCmsResource::HOST
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
}
