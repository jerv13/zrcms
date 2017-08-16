<?php

namespace Zrcms\HttpResponseHandler;

use Zrcms\HttpResponseHandler\Api\HandleResponse;
use Zrcms\HttpResponseHandler\Api\HandleResponseBasic;
use Zrcms\HttpResponseHandler\Api\HandleResponseDebug;
use Zrcms\HttpResponseHandler\Api\HandleResponseReturnOnStatus;
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
                        // @todo USE THIS: 'class' => HandleResponseBasic::class,
                        'class' => HandleResponseDebug::class
                    ],
                    HandleResponseBasic::class => [],
                    HandleResponseDebug::class => [],
                    HandleResponseReturnOnStatus::class => [],
                    HandleResponseWithExceptionMessage::class => [],
                ],
            ],
        ];
    }
}
