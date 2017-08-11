<?php

namespace Zrcms\ContentCore\Container\Api;

use Zrcms\ContentCore\Block\Model\BlockVersion;
use Zrcms\ContentCore\Container\Model\Container;
use Zrcms\ContentCore\Container\Model\ContainerVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildBlockVersions
{
    /**
     * @param Container|ContainerVersion|null $containerVersion
     * @param array                           $blockVersionsData
     *
     * @return BlockVersion[]
     */
    public static function invoke(
        $containerVersion,
        array $blockVersionsData
    ): array
    {
        if (empty($containerVersion)) {
            return [];
        }

        $blockVersions = [];

        $index = 0;
        foreach ($blockVersionsData as $blockVersionData) {

            $blockVersions[] = BuildBlockVersion::invoke(
                $containerVersion,
                $blockVersionData,
                $index
            );

            $index++;
        }

        return $blockVersions;
    }

    /**
     * @param array $blockVersionsData
     *
     * @return array
     */
    public static function prepare(
        array $blockVersionsData
    ) {
        $blockVersions = [];

        $index = 0;
        foreach ($blockVersionsData as $blockVersionData) {

            $blockVersions[] = BuildBlockVersion::prepare(
                $blockVersionData
            );

            $index++;
        }

        return $blockVersions;
    }
}
