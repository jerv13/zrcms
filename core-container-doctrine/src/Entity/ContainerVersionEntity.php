<?php

namespace Zrcms\CoreContainerDoctrine\Entity;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Zrcms\CoreApplicationDoctrine\Entity\ContentEntity;
use Zrcms\CoreApplicationDoctrine\Entity\ContentEntityAbstract;
use Zrcms\CoreContainer\Api\PrepareBlockVersionsData;
use Zrcms\CoreContainer\Fields\FieldsContainerVersion;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_container_version",
 *     indexes={}
 * )
 */
class ContainerVersionEntity extends ContentEntityAbstract implements ContentEntity
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
    protected $properties = null;

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
     * @todo this does not need to be stored in it's own column
     *
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    protected $blockVersions = [];

    /**
     * @var null|string
     */
    public $tempId = null;

    /**
     * @param string|null $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param null        $createdDate
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
        $this->blockVersions = Property::getArray(
            $properties,
            FieldsContainerVersion::BLOCK_VERSIONS,
            []
        );

        Property::remove($properties, FieldsContainerVersion::BLOCK_VERSIONS);

        Property::assertNotEmpty(
            $properties,
            FieldsContainerVersion::SITE_CMS_RESOURCE_ID
        );

        Property::assertNotEmpty(
            $properties,
            FieldsContainerVersion::PATH
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
        $properties[FieldsContainerVersion::BLOCK_VERSIONS] = $this->getBlockVersions();

        return $properties;
    }

    /**
     * @todo This should be protected
     *
     * @param array $blockVersions
     *
     * @return void
     */
    public function setBlockVersions(array $blockVersions)
    {
        $this->blockVersions = $blockVersions;
    }

    /**
     * @return string
     */
    public function getSiteCmsResourceId(): string
    {
        return $this->findProperty(
            FieldsContainerVersion::SITE_CMS_RESOURCE_ID
        );
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->findProperty(
            FieldsContainerVersion::PATH
        );
    }

    /**
     * @return array
     */
    public function getBlockVersions(): array
    {
        return $this->blockVersions;
    }

    /**
     * @todo This should not be needed the the added GUID in construct
     *
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

        $blockVersions = PrepareBlockVersionsData::invoke(
            $this->blockVersions,
            $this->id
        );

        $eventArgs->getObject()->setBlockVersions($blockVersions);

        $this->blockVersions = $blockVersions;

        $eventArgs->getObjectManager()->flush();
    }
}
