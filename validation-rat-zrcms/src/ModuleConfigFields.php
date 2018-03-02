<?php

namespace Zrcms\ValidationRatZrcms;

use Reliv\ValidationRat\Api\Validator\ValidateIsRealValue;
use Zrcms\ValidationRatZrcms\Api\Validator\ValidateCmsResourceId;
use Zrcms\ValidationRatZrcms\Api\Validator\ValidateContentVersionId;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigFields
{
    // @todo This config is in the wrong module
    public function __invoke()
    {
        return [
            'field-rat-field-types' => [
                'zrcms-cms-resource-id' => [
                    'validator' => ValidateCmsResourceId::class,
                    'validator-options' => [],
                    'validator-required' => ValidateIsRealValue::class,
                    'validator-required-options' => [],
                ],
                'zrcms-content-version-id' => [
                    'validator' => ValidateContentVersionId::class,
                    'validator-options' => [],
                    'validator-required' => ValidateIsRealValue::class,
                    'validator-required-options' => [],
                ],
            ],
        ];
    }
}
