<?php

namespace Zrcms\HttpExpressive1;

use Zrcms\Content\Api\ContentVersionToArray;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderData;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Api\Repository\FindViewByRequest;
use Zrcms\HttpExpressive1\Api\FindContentVersion;
use Zrcms\HttpExpressive1\Api\FindSiteVersion;
use Zrcms\HttpExpressive1\Render\ViewController;
use Zrcms\HttpExpressive1\Render\ViewControllerTest;
use Zrcms\HttpExpressive1\Render\ViewControllerTestFactory;

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
                    FindSiteVersion::class => [
                        'class' => FindContentVersion::class,
                        'arguments' => [
                            \Zrcms\ContentCore\Site\Api\Repository\FindSiteVersion::class,
                            ContentVersionToArray::class,
                            ['literal' => 'find-site-content-version']
                        ],
                    ],
                    /**
                     * Render ===========================================
                     */
                    ViewController::class => [
                        'arguments' => [
                            FindViewByRequest::class,
                            GetViewRenderData::class,
                            RenderView::class,
                        ],
                    ],
                    ViewControllerTest::class => [
                        'factory' => ViewControllerTestFactory::class
                    ],
                ],
            ],
//            'middleware_pipeline' => [
//                'always' => [
//                    'middleware' => [
//                        ViewControllerTest::class => ViewControllerTest::class,
//                    ],
//                ],
//            ],
            'routes' => [
                'zrcms.test-render' => [
                    'name' => 'zrcms.test-render',
                    'path' => '/zrcms/test-render',
                    'middleware' => ViewControllerTest::class,
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
                'zrcms.find-site-content-version' => [
                    'name' => 'zrcms.find-site-content-version',
                    'path' => '/zrcms/find-site-content-version/{id}',
                    'middleware' => FindSiteVersion::class,
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],
        ];
    }
}
