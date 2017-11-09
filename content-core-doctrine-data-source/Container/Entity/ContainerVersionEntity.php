<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Entity;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Zrcms\ContentCore\Container\Api\PrepareBlockVersionsData;
use Zrcms\ContentCore\Container\Fields\FieldsContainerVersion;
use Zrcms\ContentDoctrine\Entity\ContentEntity;
use Zrcms\ContentDoctrine\Entity\ContentEntityAbstract;
use Zrcms\Param\Param;

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
class ContainerVersionEntity
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
    protected $properties = null;

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
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        $this->tempId = $id;

        $this->blockVersions = Param::getArray(
            $properties,
            FieldsContainerVersion::BLOCK_VERSIONS,
            []
        );

        Param::remove($properties, FieldsContainerVersion::BLOCK_VERSIONS);

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
        $properties[FieldsContainerVersion::BLOCK_VERSIONS] = $this->getBlockVersions();

        return $properties;
    }

    /**
     * @param array $blockVersions
     *
     * @return void
     */
    public function setBlockVersions(array $blockVersions)
    {
        $this->blockVersions = $blockVersions;
    }

    /**
     * @return array
     */
    public function getBlockVersions(): array
    {
        return $this->blockVersions;
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

        $blockVersions = PrepareBlockVersionsData::invoke(
            $this->blockVersions,
            $this->id
        );

        $eventArgs->getObject()->setBlockVersions($blockVersions);

        $this->blockVersions = $blockVersions;

        $eventArgs->getObjectManager()->flush();
    }
}
