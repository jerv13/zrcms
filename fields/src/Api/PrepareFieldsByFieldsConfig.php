<?php

namespace Zrcms\Fields\Api;

use Zrcms\Fields\Model\FieldConfig;
use Zrcms\Fields\Model\FieldType;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PrepareFieldsByFieldsConfig implements PrepareFields
{
    const OPTION_FIELDS_CONFIG = 'fields-config';

    protected $validateByFieldTypeRequired;

    /**
     * @param ValidateByFieldTypeRequired $validateByFieldTypeRequired
     */
    public function __construct(
        ValidateByFieldTypeRequired $validateByFieldTypeRequired
    ) {
        $this->validateByFieldTypeRequired = $validateByFieldTypeRequired;
    }

    /**
     * @param array $fields ['{name}' => '{value}']
     * @param array $options
     *
     * @return array
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Zrcms\Param\Exception\ParamException
     */
    public function __invoke(
        array $fields,
        array $options = []
    ): array {
        $fieldsConfig = Param::getRequired(
            $options,
            static::OPTION_FIELDS_CONFIG
        );

        $fieldsConfigByName = BuildFieldsConfigNameIndex::invoke($fieldsConfig);

        $preparedFields = [];

        foreach ($fieldsConfigByName as $name => $fieldConfig) {
            $fieldType = Param::getString(
                $fieldConfig,
                FieldConfig::TYPE,
                FieldType::DEFAULT_TYPE
            );

            $fieldValue = Param::get(
                $fields,
                $name
            );

            $validationResult = $this->validateByFieldTypeRequired->__invoke(
                $fieldValue,
                [ValidateByFieldTypeRequired::OPTION_FIELD_TYPE => $fieldType]
            );

            $required = Param::getBool(
                $fieldConfig,
                FieldConfig::REQUIRED,
                false
            );

            if ($required) {
                // We can not do anything about required values
                $preparedFields[$name] = $fieldValue;
                continue;
            }

            if ($validationResult->isValid()) {
                $preparedFields[$name] = $fieldValue;
                continue;
            }

            $preparedFields[$name] = Param::get(
                $fieldConfig,
                FieldConfig::DEFAULT_VALUE,
                $fieldValue
            );
        }

        return $preparedFields;
    }
}
