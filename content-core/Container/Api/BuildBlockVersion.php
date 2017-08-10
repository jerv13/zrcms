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
     * @param array                      $blockVersionProperties
     *
     * @return BlockVersion
     */
    public static function invoke(
        Container $containerVersion,
        array $blockVersionProperties
    ): BlockVersion
    {
        // We map the IDs to this object since that are one-to-one
        $blockVersionProperties[PropertiesBlockVersion::ID] = $containerVersion->getId();
        $blockVersionProperties[PropertiesBlockVersion::BLOCK_CONTAINER_CMS_RESOURCE_ID] = $containerVersion->getId();
        $blockVersionProperties[TrackableProperties::CREATED_DATE] = $containerVersion->getCreatedDate();

        return new BlockVersionBasic(
            $blockVersionProperties,
            $containerVersion->getCreatedByUserId(),
            $containerVersion->getCreatedReason()
        );
    }
}
