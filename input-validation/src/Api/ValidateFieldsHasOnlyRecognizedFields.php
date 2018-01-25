<?php

namespace Zrcms\InputValidation\Api;

use Zrcms\InputValidation\Model\ValidationResultBasic;
use Zrcms\InputValidation\Model\ValidationResultFields;
use Zrcms\InputValidation\Model\ValidationResultFieldsBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsHasOnlyRecognizedFields implements ValidateFields
{
    const CODE_UNRECOGNIZED_FIELD = 'unrecognized-field';

    const OPTION_FIELDS_ALLOWED = 'fields-allowed';

    /**
     * @param array $fields ['{name}' => '{value}']
     * @param array $options
     *
     * @return ValidationResultFields
     */
    public function __invoke(
        array $fields,
        array $options = []
    ): ValidationResultFields {
        $allowedFields = Param::getArray(
            $options,
            static::OPTION_FIELDS_ALLOWED,
            []
        );

        $valid = true;
        $code = '';
        $details = [];
        $fieldResults = [];
        $unrecognizedFields = [];

        foreach ($fields as $fieldName => $value) {
            if (!in_array($fieldName, $allowedFields)) {
                $fieldResults[$fieldName] = new ValidationResultBasic(
                    false,
                    self::CODE_UNRECOGNIZED_FIELD,
                    ['message' => 'Unrecognized field received: (' . $fieldName . ')']
                );
                $valid = false;
                $code = static::CODE_UNRECOGNIZED_FIELD;
                $unrecognizedFields[] = $fieldName;
            }
        }

        if (!$valid) {
            $details['unrecognized-fields'] = $unrecognizedFields;
        }

        return new ValidationResultFieldsBasic(
            $valid,
            $code,
            $details,
            $fieldResults
        );
    }
}
