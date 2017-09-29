<?php

namespace Zrcms\HttpExpressive;

use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;
use Zrcms\Acl\Api\IsAllowedRelivServerEnvironmentNoneProduction;
use Zrcms\HttpExpressive\HttpTest\Acl\IsAllowedTest;
use Zrcms\HttpExpressive\HttpTest\ImplementationTest;
use Zrcms\HttpExpressive\HttpTest\ImplementationTestFactory;
use Zrcms\HttpExpressive\HttpTest\ViewControllerTest;
use Zrcms\HttpExpressive\HttpTest\ViewControllerTestFactory;

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
