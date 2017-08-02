<?php

namespace Zrcms\HttpResponseHandler;

use Zrcms\HttpResponseHandler\Api\HandleResponse;
use Zrcms\HttpResponseHandler\Api\HandleResponseBasic;
use Zrcms\HttpResponseHandler\Api\HandleResponseWithExceptionMessage;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    /**
                     * Api ===========================================
                     */
                    HandleResponse::class => [
                        'class' => HandleResponseBasic::class
                    ],
                    HandleResponseBasic::class => [],
                    HandleResponseWithExceptionMessage::class => [],
                ],
            ],
        ];
    }
}
