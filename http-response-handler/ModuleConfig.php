<?php

namespace Zrcms\HttpResponseHandler;

use Reliv\RcmApiLib\Service\PsrResponseService;
use Zrcms\HttpResponseHandler\Api\HandleResponseApi;
use Zrcms\HttpResponseHandler\Api\HandleResponseApiCompositeFactory;
use Zrcms\HttpResponseHandler\Api\HandleResponseApiDebug;
use Zrcms\HttpResponseHandler\Api\HandleResponseApiMessages;
use Zrcms\HttpResponseHandler\Api\HandleResponseApiNoop;
use Zrcms\HttpResponseHandler\Api\HandleResponseApiWithException;
use Zrcms\HttpResponseHandler\Api\HandleResponseDebug;

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
                    HandleResponseApi::class => [
                        'factory' => HandleResponseApiCompositeFactory::class,
                    ],
                    HandleResponseApiDebug::class => [
                        'arguments' => [
                            ['literal' => (ini_get('display_errors') === 1 || ini_get('display_errors') === 'On')],
                        ],
                    ],
                    HandleResponseApiMessages::class => [
                        'arguments' => [
                            PsrResponseService::class,
                        ],
                    ],
                    HandleResponseApiNoop::class => [],
                    HandleResponseApiWithException::class => [
                        'arguments' => [
                            PsrResponseService::class,
                        ],
                    ],
                ],
            ],

            'zrcms-response-handlers-api' => [
                HandleResponseDebug::class => [
                    'response-handler' => HandleResponseDebug::class,
                    'priority' => 1200
                ],
                HandleResponseApiMessages::class => [
                    'response-handler' => HandleResponseApiMessages::class,
                    'priority' => 1000
                ],
                HandleResponseApiWithException::class => [
                    'response-handler' => HandleResponseApiWithException::class,
                    'priority' => 800
                ],
                HandleResponseApiNoop::class => [
                    'response-handler' => HandleResponseApiNoop::class,
                    'priority' => 1
                ],
            ],
        ];
    }
}
