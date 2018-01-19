<?php

namespace Zrcms\InputValidation\Api;

use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateComposite implements Validate
{
    protected $validateApiList = [];

    /**
     * @param Validate $validate
     *
     * @return void
     */
    public function add(Validate $validate)
    {
        $this->validateApiList[] = $validate;
    }

    /**
     * @param mixed $value
     * @param array $options
     *
     * @return ValidationResult
     */
    public function __invoke(
        $value,
        array $options = []
    ): ValidationResult {
        $valid = true;
        $code = '';
        $validationResults = [];

        /** @var Validate $validateApi */
        foreach ($this->validateApiList as $validateApi) {
            $validationResult = $validateApi->__invoke(
                $value,
                $options
            );

            // Use the first code we get
            if (!$validationResult->isValid() && $valid) {
                $valid = false;

                $code = $validationResult->getCode();
            }

            $validationResults[] = [
                'validator' => get_class($validateApi),
                'valid' => $validationResult->isValid(),
                'code' => $validationResult->getCode(),
                'details' => $validationResult->getDetails(),
            ];
        };

        return new ValidationResultBasic(
            $valid,
            $code,
            [
                'validation-results' => $validationResults
            ]
        );
    }
}
