<?php

namespace Zrcms\CorePageDoctrine\Entity;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Zrcms\CoreApplicationDoctrine\Entity\ContentEntity;
use Zrcms\CoreApplicationDoctrine\Entity\ContentEntityAbstract;
use Zrcms\CorePage\Api\PreparePageContainerData;
use Zrcms\CorePage\Fields\FieldsPageVersion;
use Reliv\ArrayProperties\Property;

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
class PageVersionEntity extends ContentEntityAbstract implements ContentEntity
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="string")
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
     * @param        $id
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     * @param null   $createdDate
     *
     * @throws \Exception
     * @throws \Throwable
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyException
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyMissing
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        $this->title = Property::getString(
            $properties,
            FieldsPageVersion::TITLE
        );

        $this->keywords = Property::getString(
            $properties,
            FieldsPageVersion::KEYWORDS,
            ''
        );

        $this->containersData = Property::getArray(
            $properties,
            FieldsPageVersion::CONTAINERS_DATA,
            []
        );

        Property::remove($properties, FieldsPageVersion::CONTAINERS_DATA);

        Property::assertNotEmpty(
            $properties,
            FieldsPageVersion::SITE_CMS_RESOURCE_ID
        );

        Property::assertNotEmpty(
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

        $this->tempId = $this->id;
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
        return $this->findProperty(
            FieldsPageVersion::SITE_CMS_RESOURCE_ID
        );
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->findProperty(
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
