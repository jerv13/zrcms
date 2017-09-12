<?php

namespace Zrcms\HttpExpressive1;

use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;
use Zrcms\Acl\Api\IsAllowedRelivServerEnvironmentNoneProduction;
use Zrcms\HttpExpressive1\HttpTest\Acl\IsAllowedTest;
use Zrcms\HttpExpressive1\HttpTest\ImplementationTest;
use Zrcms\HttpExpressive1\HttpTest\ImplementationTestFactory;
use Zrcms\HttpExpressive1\HttpTest\ViewControllerTest;
use Zrcms\HttpExpressive1\HttpTest\ViewControllerTestFactory;
use Zrcms\HttpResponseHandler\Api\HandleResponseApi;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpTestModuleConfig
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
                     * HttpAcl ===========================================
                     */
                    IsAllowedTest::class => [
                        'arguments' => [
                            HandleResponseApi::class,
                            IsAllowedRelivServerEnvironmentNoneProduction::class,
                            ['literal' => []]
                        ],
                    ],

                    /**
                     * HttpTest ===========================================
                     */
                    ViewControllerTest::class => [
                        'factory' => ViewControllerTestFactory::class,
                    ],

                    ImplementationTest::class => [
                        'factory' => ImplementationTestFactory::class,
                    ],
                ]
            ],

            'routes' => [
                'zrcms.test-render' => [
                    'name' => 'zrcms.test-render',
                    'path' => '/zrcms/test-render',
                    'middleware' => [
                        'acl' => IsAllowedTest::class,
                        'render' => ViewControllerTest::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],

                'zrcms.test-implementation' => [
                    'name' => 'zrcms.test-implementation',
                    'path' => '/zrcms/test-implementation',
                    'middleware' => [
                        'parser' => BodyParamsMiddleware::class,
                        'acl' => IsAllowedTest::class,
                        'api' => ImplementationTest::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['POST'],
                ],
            ],
        ];
    }
}
