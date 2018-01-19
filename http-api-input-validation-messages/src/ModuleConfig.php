<?php

namespace Zrcms\HttpApiInputValidationMessages;

use Zrcms\HttpApiInputValidationMessages\Api\Response\ResponseMutatorMessagesFromResults;
use Zrcms\HttpApiInputValidationMessages\Api\Response\ResponseMutatorMessagesFromResultsFactory;

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
                    ResponseMutatorMessagesFromResults::class => [
                        'factory' => ResponseMutatorMessagesFromResultsFactory::class
                    ],
                ],
            ],
        ];
    }
}
