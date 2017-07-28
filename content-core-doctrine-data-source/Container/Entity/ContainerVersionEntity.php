<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\ContentCore\Container\Model\ContainerVersion;
use Zrcms\ContentCore\Container\Model\ContainerVersionAbstract;
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
class ContainerVersionEntity extends ContainerVersionAbstract implements ContainerVersion
{
    use ContainerBlockVersionsTrait;

    /**
     * @var string
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
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    protected $blockVersionsData = [];

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
        $blockVersions = Param::get(
            $properties,
            PropertiesContainerVersionEntity::BLOCK_VERSIONS_DATA,
            []
        );

        $this->addBlockVersions($blockVersions);

        parent::__construct($properties, $createdByUserId, $createdReason);
    }

    /**
     * @return void
     *
     * @ORM\PrePersist
     */
    public function assertHasTrackingData()
    {
        parent::assertHasTrackingData();
    }
}
