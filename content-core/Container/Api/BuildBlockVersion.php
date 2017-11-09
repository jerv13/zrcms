<?php

namespace Zrcms\ContentCore\Container\Api;

use Zrcms\Content\Model\TrackableProperties;
use Zrcms\ContentCore\Block\Fields\FieldsBlockVersion;
use Zrcms\ContentCore\Block\Model\BlockVersion;
use Zrcms\ContentCore\Block\Model\BlockVersionBasic;
use Zrcms\ContentCore\Container\Model\Container;
use Zrcms\ContentCore\Container\Model\ContainerVersion;
use Zrcms\ContentCore\Page\Model\PageVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildBlockVersion
{
    const TYPE_CONTAINER = 1;
    const TYPE_PAGE_CONTAINER = 2;

    protected static $typeMap
        = [
            Container::class => self::TYPE_CONTAINER,
            PageVersion::class => self::TYPE_PAGE_CONTAINER
        ];

    /**
     * @param ContainerVersion $containerVersion
     * @param array            $blockVersionData
     *
     * @return BlockVersion
     */
    public static function invoke(
        ContainerVersion $containerVersion,
        array $blockVersionData
    ): BlockVersion {
        $blockVersionData = PrepareBlockVersionData::invoke(
            $blockVersionData,
            $containerVersion->getId()
        );

        $blockVersionData[FieldsBlockVersion::CONTAINER_VERSION_ID] = $containerVersion->getId();

        $blockVersionData[TrackableProperties::CREATED_DATE] = $containerVersion->getCreatedDate();

        return new BlockVersionBasic(
            $blockVersionData[FieldsBlockVersion::RENDER_DATA_ID],
            $blockVersionData,
            $containerVersion->getCreatedByUserId(),
            $containerVersion->getCreatedReason()
        );
    }
}
