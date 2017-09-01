<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Content\Model\PropertiesContent;
use Zrcms\ContentCore\Container\Model\ContainerVersion;
use Zrcms\ContentCore\Container\Model\ContainerVersionAbstract;
use Zrcms\ContentDoctrine\Entity\ContentEntity;
use Zrcms\ContentDoctrine\Entity\ContentEntityTrait;
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
    extends ContainerVersionAbstract
    implements ContainerVersion, ContentEntity
{
    use ContentEntityTrait;

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
            PropertiesContent::ID
        );

        $this->blockVersions = Param::getArray(
            $properties,
            PropertiesContainerVersionEntity::BLOCK_VERSIONS,
            []
        );

        Param::remove($properties, PropertiesContainerVersionEntity::BLOCK_VERSIONS);

        parent::__construct(
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
        $properties[PropertiesContainerVersionEntity::BLOCK_VERSIONS] = $this->getBlockVersions();

        return $properties;
    }

    /**
     * @return array
     */
    public function getBlockVersions(): array
    {
        return $this->blockVersions;
    }
}
