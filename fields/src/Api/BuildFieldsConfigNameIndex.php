<?php

namespace Zrcms\Fields\Api;

use Zrcms\Fields\Model\FieldConfig;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildFieldsConfigNameIndex
{
    /**
     * @param array $fieldsConfig
     *
     * @return array
     * @throws \Throwable
     * @throws \Zrcms\Param\Exception\ParamException
     */
    public static function invoke(
        array $fieldsConfig
    ): array {
        $fieldsConfigByName = [];
        foreach ($fieldsConfig as $fieldConfig) {
            $name = Param::getRequired(
                $fieldConfig,
                FieldConfig::NAME
            );
            $fieldsConfigByName[$name] = $fieldConfig;
        }

        return $fieldsConfigByName;
    }
}
