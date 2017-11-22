<?php

namespace Zrcms\HttpTest;

use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;
use Zrcms\Acl\Api\IsAllowedRelivServerEnvironmentNoneProduction;
use Zrcms\HttpTest\Acl\IsAllowedTest;
use Zrcms\HttpTest\Middleware\ImplementationTest;
use Zrcms\HttpTest\Middleware\ImplementationTestFactory;
use Zrcms\HttpTest\Middleware\ViewControllerTest;
use Zrcms\HttpTest\Middleware\ViewControllerTestFactory;

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
                    'options' => [
                        'test-opt' => 'MEEE'
                    ],
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
