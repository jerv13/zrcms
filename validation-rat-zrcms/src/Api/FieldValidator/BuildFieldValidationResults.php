<?php

namespace Zrcms\ValidationRatZrcms\Api\FieldValidator;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BuildFieldValidationResults
{
    /**
     * @param array  $data
     * @param array  $fieldResults
     * @param string $fieldKey
     * @param string $validatorKey
     * @param string $optionsKey
     * @param string $defaultValidator
     * @param array  $defaultValidatorOptions
     * @param array  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        array $data,
        array $fieldResults,
        string $fieldKey,
        string $validatorKey,
        string $optionsKey,
        string $defaultValidator,
        array $defaultValidatorOptions,
        array $options = []
    ): array;
}
