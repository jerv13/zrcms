<?php

namespace Zrcms\HttpRcmApiLib;

use Reliv\RcmApiLib\Api\ApiResponse\NewPsrResponseWithTranslatedMessages;
use Zrcms\HttpRcmApiLib\Response\ResponseMutatorJsonRcmApiLibFormat;

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
                    ResponseMutatorJsonRcmApiLibFormat::class => [
                        'arguments' => [
                            NewPsrResponseWithTranslatedMessages::class,
                        ],
                    ],
                ],
            ],
        ];
    }
}
