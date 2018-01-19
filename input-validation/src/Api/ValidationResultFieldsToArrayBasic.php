<?php

namespace Zrcms\InputValidation\Api;

use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidationResultFieldsToArrayBasic implements ValidationResultFieldsToArray
{
    protected $validationResultToArray;

    /**
     * @param ValidationResultToArray $validationResultToArray
     */
    public function __construct(
        ValidationResultToArray $validationResultToArray
    ) {
        $this->validationResultToArray = $validationResultToArray;
    }

    /**
     * @param ValidationResultFields $validationResultFields
     * @param array                  $options
     *
     * @return array
     */
    public function __invoke(
        ValidationResultFields $validationResultFields,
        array $options = []
    ): array {
        $array = $this->validationResultToArray->__invoke(
            $validationResultFields,
            $options
        );

        $array['fieldResults'] = $this->buildFieldResultsArray(
            $validationResultFields->getFieldResults()
        );

        return $array;
    }

    /**
     * @param array $validationResults
     * @param array $options
     *
     * @return array
     */
    protected function buildFieldResultsArray(
        array $validationResults,
        array $options = []
    ): array {
        $results = [];
        /** @var ValidationResult $validationResult */
        foreach ($validationResults as $fieldName => $validationResult) {
            if ($validationResult instanceof ValidationResultFields) {
                $results[$fieldName] = $this->__invoke(
                    $validationResult,
                    $options
                );
                continue;
            }

            $results[$fieldName] = $this->validationResultToArray->__invoke(
                $validationResult,
                $options
            );
        }

        return $results;
    }
}
