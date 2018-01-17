<?php

namespace Zrcms\InputValidation\Api;

use Zrcms\InputValidation\Model\ValidationResult;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ValidationResultToArray
{
    /**
     * @param ValidationResult $validationResult
     * @param array            $options
     *
     * @return array
     */
    public function __invoke(
        ValidationResult $validationResult,
        array $options = []
    ): array;
}
