<?php

namespace Zrcms\ValidationRatZrcmsSite;

use Zrcms\ValidationRatZrcms\Api\Validator\ValidateId;
use Zrcms\ValidationRatZrcms\Api\Validator\ValidateIdBasicFactory;

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
