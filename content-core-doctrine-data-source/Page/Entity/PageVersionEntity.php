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
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $keywords;

    /**
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
     * @param string|null $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
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

        parent::__construct(
            $id,
            $properties,
            $createdByUserId,
            $createdReason
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
        $this->properties[FieldsPageVersion::TITLE] = $this->title;
        $this->properties[FieldsPageVersion::KEYWORDS] = $this->keywords;

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
