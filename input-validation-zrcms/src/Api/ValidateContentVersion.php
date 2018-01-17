<?php

namespace Zrcms\InputValidationZrcms\Api;

use Zrcms\InputValidation\Api\ValidateFields;
use Zrcms\InputValidation\Model\ValidationResultFields;
use Zrcms\InputValidation\Model\ValidationResultFieldsBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateContentVersion implements ValidateFields
{
    /**
     * @param array $contentVersionData ['{name}' => '{value}']
     * @param array $options
     *
     * @return ValidationResultFields
     */
    public function __invoke(
        array $contentVersionData,
        array $options = []
    ): ValidationResultFields {
        // @todo Write me
        return new ValidationResultFieldsBasic();
    }
}
