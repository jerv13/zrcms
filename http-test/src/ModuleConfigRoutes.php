<?php

namespace Zrcms\HttpTest;

use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;
use Zrcms\HttpTest\Acl\IsAllowedTestIsAllowed;
use Zrcms\HttpTest\Middleware\HttpImplementationTest;
use Zrcms\HttpTest\Middleware\HttpViewTest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigRoutes
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'routes' => [
                'zrcms.test-render' => [
                    'name' => 'zrcms.test-render',
                    'path' => '/zrcms/test-render',
                    'middleware' => [
                        'acl' => IsAllowedTestIsAllowed::class,
                        'render' => HttpViewTest::class,
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
                        'acl' => IsAllowedTestIsAllowed::class,
                        'api' => HttpImplementationTest::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['POST'],
                ],
            ],
        ];
    }
}
