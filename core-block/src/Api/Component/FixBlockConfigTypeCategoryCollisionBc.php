<?php

namespace Zrcms\CoreBlock\Api\Component;

use Zrcms\CoreBlock\Fields\FieldsBlockComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FixBlockConfigTypeCategoryCollisionBc
{
    /**
     * @param array $rcmPluginConfig
     * @param array $componentConfig
     *
     * @return array
     */
    public static function invoke(
        array $rcmPluginConfig,
        array $componentConfig = []
    ): array {
        if (empty($rcmPluginConfig[FieldsBlockComponentConfig::TYPE])) {
            $rcmPluginConfig[FieldsBlockComponentConfig::TYPE] = 'block';
        }
        // FIX for collisions
        if ($rcmPluginConfig[FieldsBlockComponentConfig::TYPE] !== 'block') {
            $componentConfig[FieldsBlockComponentConfig::CATEGORY]
                = $rcmPluginConfig[FieldsBlockComponentConfig::TYPE];
            $componentConfig[FieldsBlockComponentConfig::TYPE] = 'block';
        }

        return $componentConfig;
    }
}
