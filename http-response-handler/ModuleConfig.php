<?php

namespace Zrcms\HttpResponseHandler;

use Reliv\RcmApiLib\Service\PsrResponseService;
use Zrcms\HttpResponseHandler\Api\HandleResponse;
use Zrcms\HttpResponseHandler\Api\HandleResponseApi;
use Zrcms\HttpResponseHandler\Api\HandleResponseApiCompositeFactory;
use Zrcms\HttpResponseHandler\Api\HandleResponseApiMessages;
use Zrcms\HttpResponseHandler\Api\HandleResponseApiWithException;
use Zrcms\HttpResponseHandler\Api\HandleResponseBasic;
use Zrcms\HttpResponseHandler\Api\HandleResponseCompositeFactory;
use Zrcms\HttpResponseHandler\Api\HandleResponseDebug;
use Zrcms\HttpResponseHandler\Api\HandleResponseNextOnError;
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
                        'factory' => HandleResponseCompositeFactory::class,
                    ],
                    HandleResponseApi::class => [
                        'factory' => HandleResponseApiCompositeFactory::class,
                    ],
                    HandleResponseApiMessages::class => [
                        'arguments' => [
                            PsrResponseService::class,
                        ],
                    ],
                    HandleResponseApiWithException::class => [
                        'arguments' => [
                            PsrResponseService::class,
                        ],
                    ],
                    HandleResponseBasic::class => [],
                    HandleResponseDebug::class => [],
                    HandleResponseNextOnError::class => [],
                    HandleResponseWithExceptionMessage::class => [],
                ],
            ],

            'zrcms-response-handlers' => [
                HandleResponseDebug::class => [
                    'response-handler' => HandleResponseDebug::class,
                    'priority' => 1000
                ],

                HandleResponseWithExceptionMessage::class => [
                    'response-handler' => HandleResponseWithExceptionMessage::class,
                    'priority' => 800
                ],

                // NOTE: this will push the error response to the next middleware
                //       if NEXT and REQUEST are set
                HandleResponseNextOnError::class => [
                    'response-handler' => HandleResponseNextOnError::class,
                    'priority' => 200
                ],

                HandleResponseBasic::class => [
                    'response-handler' => HandleResponseBasic::class,
                    'priority' => 1
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
                HandleResponseBasic::class => [
                    'response-handler' => HandleResponseBasic::class,
                    'priority' => 1
                ],
            ],
        ];
    }
}
