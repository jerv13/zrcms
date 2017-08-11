<?php

namespace Zrcms\ContentCore\Container\Api;

use Zrcms\Content\Model\TrackableProperties;
use Zrcms\ContentCore\GetDomId;
use Zrcms\ContentCore\Block\Model\BlockVersion;
use Zrcms\ContentCore\Block\Model\BlockVersionBasic;
use Zrcms\ContentCore\Block\Model\PropertiesBlockVersion;
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

        $blockVersionData[PropertiesBlockVersion::CONTAINER_VERSION_ID] = $containerVersion->getId();

        $blockVersionData[PropertiesBlockVersion::ID] = GetDomId::invoke();

        $blockVersionData[TrackableProperties::CREATED_DATE] = $containerVersion->getCreatedDate();

        return new BlockVersionBasic(
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
        $blockVersionData[PropertiesBlockVersion::CONTAINER_VERSION_ID] = '';

        $blockVersionData[PropertiesBlockVersion::ID] = '';

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

    /**
     * @param       $value
     * @param array $params
     *
     * @return mixed|string
     */
    public static function parseFormat(
        $value,
        array $params
    ): string
    {
        $value = (string)$value;

        foreach ($params as $paramName => $param) {
            $value = str_replace('{{' . $paramName . '}}', $param, $value);
        }

        return $value;
    }
}
