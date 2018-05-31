<?php

namespace Zrcms\CoreBlock\Api\Component;

use Reliv\FieldRat\Model\FieldConfig;
use Zrcms\CoreBlock\Fields\FieldsBlockComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PrepareComponentConfigBlockFieldsToDefaultConfig implements PrepareComponentConfigBlock
{
    /**
     * @param array $blockConfig
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        array $blockConfig,
        array $options = []
    ): array {
        if (isset($blockConfig[FieldsBlockComponentConfig::DEFAULT_CONFIG])) {
            $blockConfig[FieldsBlockComponentConfig::DEFAULT_CONFIG] = [];
        }

        if (!isset($blockConfig[FieldsBlockComponentConfig::FIELDS])) {
            return $blockConfig;
        }

        if (!is_array($blockConfig[FieldsBlockComponentConfig::FIELDS])) {
            throw new \Exception(
                'Block config ' . FieldsBlockComponentConfig::DEFAULT_CONFIG
                . ' must be array'
            );
        }

        $defaultConfig = [];

        foreach ($blockConfig[FieldsBlockComponentConfig::FIELDS] as $field) {
            $defaultConfig[$field[FieldConfig::NAME]] = $field[FieldConfig::DEFAULT_VALUE];
        }

        $blockConfig[FieldsBlockComponentConfig::DEFAULT_CONFIG] = $defaultConfig;

        return $blockConfig;
    }
}
