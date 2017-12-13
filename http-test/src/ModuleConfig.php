<?php

namespace Zrcms\HttpTest;

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
        ];
    }
}
