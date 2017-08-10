<?php

namespace Zrcms\ContentCore\Container\Api;

use Zrcms\Content\Model\TrackableProperties;
use Zrcms\ContentCore\Block\Model\BlockVersion;
use Zrcms\ContentCore\Block\Model\BlockVersionBasic;
use Zrcms\ContentCore\Block\Model\PropertiesBlockVersion;
use Zrcms\ContentCore\Container\Model\Container;
use Zrcms\ContentCore\Container\Model\ContainerVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildBlockVersion
{
    /**
     * @param Container|ContainerVersion $containerVersion
     * @param array                      $blockVersionData
     *
     * @return BlockVersion
     */
    public static function invoke(
        Container $containerVersion,
        array $blockVersionData,
        $containerBlockIndex
    ): BlockVersion
    {

        $blockVersionData[PropertiesBlockVersion::CONTAINER_VERSION_ID] = $containerVersion->getId();
        // @todo Why is this required
        $blockVersionData[PropertiesBlockVersion::BLOCK_CONTAINER_CMS_RESOURCE_ID] = $containerVersion->getId();
        $blockVersionData[TrackableProperties::CREATED_DATE] = $containerVersion->getCreatedDate();

        if (!array_key_exists(PropertiesBlockVersion::ID, $blockVersionData)
            || empty($blockVersionData[PropertiesBlockVersion::ID])
        ) {
            // @todo FIX this
            $blockVersionData[PropertiesBlockVersion::ID] = $containerVersion->getId() . '.' . $containerBlockIndex;
        }

        return new BlockVersionBasic(
            $blockVersionData,
            $containerVersion->getCreatedByUserId(),
            $containerVersion->getCreatedReason()
        );
    }
}
