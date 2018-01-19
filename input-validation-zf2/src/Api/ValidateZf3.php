<?php

namespace Zrcms\InputValidationZf2\Api;

use Zend\Validator\ValidatorInterface;
use Zrcms\InputValidation\Api\Validate;
use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateZf3 extends ValidateZf implements Validate
{
    /**
     * @param ValidatorInterface $validator
     * @param                    $value
     * @param array              $options
     *
     * @return ValidationResult
     */
    protected function validate(
        ValidatorInterface $validator,
        $value,
        array $options = []
    ): ValidationResult {
        $name = Param::getString(
            $options,
            static::OPTION_NAME,
            'default'
        );

        $valid = $validator->isValid($value);

        // @todo ZF3 Validators may return a result object, deal with the result here

        $messages = $validator->getMessages();

        $result = new ValidationResultBasic(
            $valid,
            $this->buildCode($valid, $messages),
            [
                'zf2' => true,
                'messages-zf2' => $messages,
                'name' => $name,
                'validator-zf2' => get_class($validator),
            ]
        );

        return $result;
    }
}
