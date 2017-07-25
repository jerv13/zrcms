<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Entity;

use Zrcms\ContentCore\Block\Model\BlockVersion;
use Zrcms\ContentCoreDoctrineDataSource\Block\Model\BlockVersionEntity;
use Zrcms\ContentCoreDoctrineDataSource\Block\Model\PropertiesBlockVersionEntity;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
trait ContainerBlockVersionsTrait
{
    /**
     * @var array
     */
    protected $blockVersionsData = [];

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
        $blockVersionData = $blockVersion->getProperties();
        $blockVersionData[PropertiesBlockVersionEntity::CREATED_BY_USER_ID] = $blockVersion->getCreatedByUserId();
        $blockVersionData[PropertiesBlockVersionEntity::CREATED_REASON] = $blockVersion->getCreatedReason();
        $blockVersionData[PropertiesBlockVersionEntity::CREATED_DATE] = $blockVersion->getCreatedDate();
        // We map the IDs to this object since that are one-to-one
        $blockVersionData[PropertiesBlockVersionEntity::ID] = $this->getId();
        $blockVersionData[PropertiesBlockVersionEntity::BLOCK_CONTAINER_CMS_RESOURCE_ID] = $this->getId();

        $this->blockVersionsData[$blockVersion->getId()] = $blockVersionData;
    }

    /**
     * @param $blockVersionData
     *
     * @return BlockVersion
     */
    protected function buildBlockVersion(array $blockVersionData): BlockVersion
    {
        // We map the IDs to this object since that are one-to-one
        $blockVersionData[PropertiesBlockVersionEntity::ID] = $this->getId();
        $blockVersionData[PropertiesBlockVersionEntity::BLOCK_CONTAINER_CMS_RESOURCE_ID] = $this->getId();

        return new BlockVersionEntity(
            $blockVersionData,
            Param::getRequired(
                $blockVersionData,
                PropertiesBlockVersionEntity::CREATED_BY_USER_ID
            ),
            Param::getRequired(
                $blockVersionData,
                PropertiesBlockVersionEntity::CREATED_REASON
            )
        );
    }
}
