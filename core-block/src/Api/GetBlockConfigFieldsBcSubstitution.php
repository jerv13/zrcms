<?php

namespace Zrcms\CoreBlock\Api;

use Zrcms\CoreBlock\Fields\FieldsBlockComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockConfigFieldsBcSubstitution
{
    /**
     * @var array
     */
    protected $bcFields
        = [
            'name' => FieldsBlockComponentConfig::NAME,
            'type' => FieldsBlockComponentConfig::CATEGORY, // NOTE: this has a collision
            'display' => FieldsBlockComponentConfig::LABEL,
            'tooltip' => FieldsBlockComponentConfig::DESCRIPTION,
            'icon' => FieldsBlockComponentConfig::ICON,
            'canCache' => FieldsBlockComponentConfig::CACHEABLE,
            'defaultInstanceConfig' => FieldsBlockComponentConfig::DEFAULT_CONFIG,
        ];

    /**
     * @return array
     */
    public function __invoke()
    {
        return $this->bcFields;
    }
}
