<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Entity;

use Zrcms\ContentCore\Block\Model\BlockVersion;
use Zrcms\ContentCore\Container\Model\ContainerVersion;
use Zrcms\ContentCore\Container\Model\ContainerVersionAbstract;
use Zrcms\ContentCoreDoctrineDataSource\Block\Entity\BlockVersionEntity;
use Zrcms\ContentCoreDoctrineDataSource\Block\Model\PropertiesBlockVersionEntity;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ContainerVersionEntity extends ContainerVersionAbstract implements ContainerVersion
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var array
     */
    protected $properties = null;

    /**
     * Date object was first created
     *
     * @var \DateTime
     */
    protected $createdDate;

    /**
     * User ID of creator
     *
     * @var string
     */
    protected $createdByUserId;

    /**
     * Short description of create reason
     *
     * @var string
     */
    protected $createdReason;

    /////////////////////////////////////

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
        $this->blockVersionsData = Param::get(
            $properties,
            PropertiesContainerVersionEntity::BLOCK_VERSIONS_DATA,
            []
        );

        parent::__construct($properties, $createdByUserId, $createdReason);
    }


    /**
     * @return BlockVersion[]
     */
    public function getBlockVersions(): array
    {
        $blockVersions = [];
        /** @var array $blockVersionData */
        foreach ($this->blockVersionsData as $blockVersionData) {
            $blockVersions[] = $this->buildBlockVersion($blockVersionData);
        }

        return $blockVersions;
    }

    /**
     * @param int  $id ,
     * @param null $default
     *
     * @return BlockVersion
     */
    public function getBlockVersion(int $id, $default = null): BlockVersion
    {
        if (array_key_exists($id, $this->blockVersionsData)) {
            return $this->buildBlockVersion($this->blockVersionsData[$id]);
        }

        return $default;
    }

    /**
     * @param BlockVersion[] $blockVersions
     *
     * @return void
     */
    protected function addBlockVersions(array $blockVersions)
    {
        /** @var BlockVersion $blockVersion */
        foreach ($blockVersions as $blockVersion) {
            $this->addBlockVersion($blockVersion);
        }
    }

    /**
     * @param BlockVersion $blockVersion
     *
     * @return void
     */
    protected function addBlockVersion(BlockVersion $blockVersion)
    {
        $data = $blockVersion->getProperties();
        $data[PropertiesBlockVersionEntity::CREATED_BY_USER_ID] = $blockVersion->getCreatedByUserId();
        $data[PropertiesBlockVersionEntity::CREATED_REASON] = $blockVersion->getCreatedReason();
        $data[PropertiesBlockVersionEntity::CREATED_DATE] = $blockVersion->getCreatedDate();

        $this->blockVersionsData[$blockVersion->getId()] = $data;
    }

    /**
     * @param $blockVersion
     *
     * @return BlockVersion
     */
    protected function buildBlockVersion(array $blockVersion): BlockVersion
    {
        return new BlockVersionEntity(
            $blockVersion,
            Param::getRequired(
                $blockVersion,
                PropertiesBlockVersionEntity::CREATED_BY_USER_ID
            ),
            Param::getRequired(
                $blockVersion,
                PropertiesBlockVersionEntity::CREATED_REASON
            )
        );
    }
}
