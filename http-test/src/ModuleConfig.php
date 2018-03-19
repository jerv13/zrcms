<?php

namespace Zrcms\HttpTest;

use Zrcms\HttpTest\Acl\IsAllowedTestIsAllowed;
use Zrcms\HttpTest\Acl\IsAllowedTestIsAllowedFactory;
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
                        'factory' => IsAllowedTestIsAllowedFactory::class,
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
