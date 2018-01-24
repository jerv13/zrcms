<?php

namespace Zrcms\InputValidationZrcmsSite;

use Zrcms\InputValidationZrcms\Api\ValidateId;
use Zrcms\InputValidationZrcms\Api\ValidateIdBasicFactory;

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
        return [
            'dependencies' => [
                'config_factories' => [
                    ValidateId::class => [
                        'factory' => ValidateIdBasicFactory::class,
                    ],
                ],
            ],
        ];
    }
}
