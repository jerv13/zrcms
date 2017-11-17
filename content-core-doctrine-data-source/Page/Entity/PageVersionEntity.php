<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Entity;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Zrcms\ContentCore\Page\Api\PreparePageContainerData;
use Zrcms\ContentCore\Page\Fields\FieldsPageVersion;
use Zrcms\ContentDoctrine\Entity\ContentEntity;
use Zrcms\ContentDoctrine\Entity\ContentEntityAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_page_version",
 *     indexes={}
 * )
 */
class PageVersionEntity
    extends ContentEntityAbstract
    implements ContentEntity
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
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $keywords;

    /**
     * @todo this does not need to be stored in it's own column
     *
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    protected $containersData = [];

    /**
     * @var null|string
     */
    public $tempId = null;

    /**
     * @param null|string $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param null        $createdDate
     *
     * @throws \Exception
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        if(is_object($id)) {
            throw new \Exception(
                'got ' . get_class($id)
            );
        }
        $this->tempId = $id;

        $this->title = Param::getString(
            $properties,
            FieldsPageVersion::TITLE
        );

        $this->keywords = Param::getString(
            $properties,
            FieldsPageVersion::KEYWORDS
        );

        $this->containersData = Param::getArray(
            $properties,
            FieldsPageVersion::CONTAINERS_DATA,
            []
        );

        Param::remove($properties, FieldsPageVersion::CONTAINERS_DATA);

        Param::assertNotEmpty(
            $properties,
            FieldsPageVersion::SITE_CMS_RESOURCE_ID
        );

        Param::assertNotEmpty(
            $properties,
            FieldsPageVersion::PATH
        );

        parent::__construct(
            $id,
            $properties,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        $properties = parent::getProperties();
        $properties[FieldsPageVersion::CONTAINERS_DATA] = $this->getContainersData();

        return $properties;
    }

    /**
     * @return string
     */
    public function getSiteCmsResourceId(): string
    {
        return $this->getProperty(
            FieldsPageVersion::SITE_CMS_RESOURCE_ID
        );
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->getProperty(
            FieldsPageVersion::PATH
        );
    }

    /**
     * @todo This should be protected
     *
     * @param array $containersData
     *
     * @return void
     */
    public function setContainersData(array $containersData)
    {
        $this->containersData = $containersData;
    }

    /**
     * @return array
     */
    public function getContainersData(): array
    {
        return $this->containersData;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     *
     * @return void
     *
     * @ORM\PostPersist
     */
    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        if ($this->tempId == $this->id) {
            return;
        }

        $this->tempId = $this->id;

        $containersData = PreparePageContainerData::invoke(
            $this->id,
            $this->containersData
        );

        $eventArgs->getObject()->setContainersData($containersData);

        $this->containersData = $containersData;

        $eventArgs->getObjectManager()->flush();
    }
}