<?php

namespace Zrcms\Fields\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Fields\Api\FieldType\FindFieldType;
use Zrcms\Fields\Model\FieldTypeConfig;
use Zrcms\InputValidation\Api\Validate;
use Zrcms\InputValidation\Api\ValidateFields;
use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateByFieldType implements Validate
{
    const OPTION_FIELD_TYPE = 'field-type';

    protected $serviceContainer;
    protected $findFieldType;

    /**
     * @param ContainerInterface $serviceContainer
     * @param FindFieldType      $findFieldType
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        FindFieldType $findFieldType
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->findFieldType = $findFieldType;
    }

    /**
     * @param mixed $value
     * @param array $options
     *
     * @return ValidationResult
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Zrcms\Param\Exception\ParamException
     */
    public function __invoke(
        $value,
        array $options = []
    ): ValidationResult {
        $fieldType = Param::getRequired(
            $options,
            static::OPTION_FIELD_TYPE
        );

        $fieldTypeObject = $this->findFieldType->__invoke(
            $fieldType
        );

        if (empty($fieldTypeObject)) {
            throw new \Exception(
                'Field type: (' . $fieldType . ') not found'
            );
        }

        /** @var Validate|ValidateFields $validator */
        $validator = $this->serviceContainer->get(
            $fieldTypeObject->findProperty(
                FieldTypeConfig::VALIDATOR
            )
        );

        $validatorOptions = $fieldTypeObject->findProperty(
            FieldTypeConfig::VALIDATOR_OPTIONS
        );

        return $validator->__invoke(
            $value,
            $validatorOptions
        );
    }
}
