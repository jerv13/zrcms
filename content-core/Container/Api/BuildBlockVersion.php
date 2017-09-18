<?php

namespace Zrcms\ContentCore\Container\Api;

use Zrcms\Content\Model\TrackableProperties;
use Zrcms\ContentCore\GetDomId;
use Zrcms\ContentCore\Block\Model\BlockVersion;
use Zrcms\ContentCore\Block\Model\BlockVersionBasic;
use Zrcms\ContentCore\Block\Fields\FieldsBlockVersion;
use Zrcms\ContentCore\Container\Model\Container;
use Zrcms\ContentCore\Container\Model\ContainerVersion;
use Zrcms\ContentCore\Page\Model\PageContainerVersion;

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
            PageContainerVersion::class => self::TYPE_PAGE_CONTAINER
        ];

    /**
     * @param ContainerVersion $containerVersion
     * @param array            $blockVersionData
     * @param int              $containerBlockIndex
     *
     * @return BlockVersion
     */
    public static function invoke(
        ContainerVersion $containerVersion,
        array $blockVersionData,
        int $containerBlockIndex
    ): BlockVersion
    {
        $blockVersionData = self::prepare(
            $blockVersionData
        );

        $blockVersionData[FieldsBlockVersion::CONTAINER_VERSION_ID] = $containerVersion->getId();

        $id = GetDomId::invoke();

        $blockVersionData[TrackableProperties::CREATED_DATE] = $containerVersion->getCreatedDate();

        return new BlockVersionBasic(
            $id,
            $blockVersionData,
            $containerVersion->getCreatedByUserId(),
            $containerVersion->getCreatedReason()
        );
    }

    /**
     * @param array $blockVersionData
     *
     * @return array
     */
    public static function prepare(
        array $blockVersionData
    ): array
    {
        $blockVersionData[FieldsBlockVersion::CONTAINER_VERSION_ID] = '';

        return $blockVersionData;
    }

    /**
     * @param ContainerVersion $containerVersion
     *
     * @return mixed
     * @throws \Exception
     */
    public static function getType(
        ContainerVersion $containerVersion
    ) {
        $type = null;

        foreach (self::$typeMap as $interface => $type) {
            if (is_a($containerVersion, $interface)) {
                return $type;
            }
        }

        throw new \Exception('Type not found for: ' . get_class($containerVersion));
    }
}
