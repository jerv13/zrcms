<?php

namespace Reliv\ServiceAlias;

use Reliv\ValidationRat\Api\Validator\ValidateIsRealValue;
use Zrcms\ValidationRatZrcms\Api\ValidateIsZrcmsServiceAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigFields
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            /**
             * ===== Field Types =====
             */
            'field-rat-field-types' => [
                'zrcms-service' => [
                    'validator' => ValidateIsZrcmsServiceAlias::class,
                    'validator-options' => [],
                    'validator-required' => ValidateIsRealValue::class,
                    'validator-required-options' => [],
                ],
            ],
        ];
    }
}
