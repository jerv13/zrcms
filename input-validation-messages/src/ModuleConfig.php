<?php

namespace Zrcms\InputValidationMessages;

use Zrcms\InputValidation\Model\ValidationResultBasic;
use Zrcms\InputValidation\Model\ValidationResultFieldsBasic;
use Zrcms\InputValidationMessages\Api\GetMessagesValidationResultBasic;
use Zrcms\InputValidationMessages\Api\GetMessagesValidationResultFieldsBasic;
use Zrcms\InputValidationMessages\Test\TestBasicImplementation;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * @return array
     */
    public function __invoke()
    {
        TestBasicImplementation::test(); die;
        return [
            'dependencies' => [
                'config_factories' => [
                ],
            ],
        ];
    }
}
