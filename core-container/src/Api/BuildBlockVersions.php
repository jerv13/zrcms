<?php

namespace Zrcms\CoreContainer\Api;

use Zrcms\CoreBlock\Model\BlockVersion;
use Zrcms\CoreContainer\Model\Container;
use Zrcms\CoreContainer\Model\ContainerVersion;

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
    ): array {
        if (empty($containerVersion)) {
            return [];
        }

        $blockVersions = [];

        foreach ($blockVersionsData as $blockVersionData) {

            $blockVersions[] = BuildBlockVersion::invoke(
                $containerVersion,
                $blockVersionData
            );
        }

        return $blockVersions;
    }
}
