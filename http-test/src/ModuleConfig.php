<?php

namespace Zrcms\HttpTest;

use Zrcms\Acl\Api\IsAllowedRelivServerEnvironmentNoneProduction;
use Zrcms\HttpTest\Acl\IsAllowedTestIsAllowed;
use Zrcms\HttpTest\Middleware\HttpImplementationTest;
use Zrcms\HttpTest\Middleware\HttpImplementationTestFactory;
use Zrcms\HttpTest\Middleware\HttpViewTest;
use Zrcms\HttpTest\Middleware\HttpViewTestFactory;

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
                    /**
                     * HttpAcl ===========================================
                     */
                    IsAllowedTestIsAllowed::class => [
                        'arguments' => [
                            IsAllowedRelivServerEnvironmentNoneProduction::class,
                            ['literal' => []]
                        ],
                    ],

                    /**
                     * HttpTest ===========================================
                     */
                    HttpViewTest::class => [
                        'factory' => HttpViewTestFactory::class,
                    ],

                    HttpImplementationTest::class => [
                        'factory' => HttpImplementationTestFactory::class,
                    ],
                ]
            ],
        ];
    }
}
