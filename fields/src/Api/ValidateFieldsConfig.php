<?php

namespace Zrcms\Fields\Api;

use Zrcms\InputValidation\Api\ValidateFields;
use Zrcms\InputValidation\Model\ValidationResultFields;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsConfig implements ValidateFields
{
    const OPTION_FIELDS_CONFIG = 'fields-config';

    public function __construct()
    {
    }

    /**
     * @param array $fields ['{name}' => '{value}']
     * @param array $options
     *
     * @return ValidationResultFields
     * @throws \Throwable
     * @throws \Zrcms\Param\Exception\ParamException
     */
    public function __invoke(
        array $fields,
        array $options = []
    ): ValidationResultFields {
        $fieldsConfig = Param::getRequired(
            $options,
            static::OPTION_FIELDS_CONFIG
        );

        $fieldOptions = Param::getArray(
            $options,
            xxx
        );
    }
}
