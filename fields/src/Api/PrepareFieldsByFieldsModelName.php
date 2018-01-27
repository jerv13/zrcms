<?php

namespace Zrcms\Fields\Api;

use Zrcms\Fields\Api\Field\FindFieldsByModel;
use Zrcms\Fields\Model\FieldConfig;
use Zrcms\Fields\Model\FieldType;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PrepareFieldsByFieldsModelName implements PrepareFields
{
    const OPTION_FIELDS_MODEL_NAME = 'fields-model-name';

    protected $validateByFieldTypeRequired;
    protected $findFieldsByModel;

    /**
     * @param ValidateByFieldTypeRequired $validateByFieldTypeRequired
     * @param FindFieldsByModel           $findFieldsByModel
     */
    public function __construct(
        ValidateByFieldTypeRequired $validateByFieldTypeRequired,
        FindFieldsByModel $findFieldsByModel
    ) {
        $this->validateByFieldTypeRequired = $validateByFieldTypeRequired;
        $this->findFieldsByModel = $findFieldsByModel;
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
        $modelName = Param::getRequired(
            $options,
            static::OPTION_FIELDS_MODEL_NAME
        );

        $fieldsModel= $this->findFieldsByModel->__invoke(
            $modelName
        );

        if (empty($fieldsModel)) {
            throw new \Exception(
                'No fields found for field model: ' . $modelName
            );
        }

        return $this->prepare(
            $fields,
            $fieldsModel->getFieldsConfig()
        );
    }

    /**
     * @param array $fields
     * @param array $fieldsConfig
     *
     * @return array
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Zrcms\Param\Exception\ParamException
     */
    protected function prepare(
        array $fields,
        array $fieldsConfig
    ):array {
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
