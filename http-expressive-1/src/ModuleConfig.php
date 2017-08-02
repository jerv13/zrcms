<?php

namespace Zrcms\HttpExpressive1;

use Zrcms\Content\Api\ContentVersionToArray;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderData;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Api\Repository\FindViewByRequest;
use Zrcms\HttpExpressive1\Api\Site\Repository\FindSiteVersion;
use Zrcms\HttpExpressive1\Api\Site\Repository\InsertSiteVersion;
use Zrcms\HttpExpressive1\Render\ViewController;
use Zrcms\HttpExpressive1\Render\ViewControllerTest;
use Zrcms\HttpExpressive1\Render\ViewControllerTestFactory;
use Zrcms\HttpResponseHandler\Api\HandleResponseWithExceptionMessage;
use Zrcms\User\Api\GetUserIdByRequest;

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
                        'arguments' => [
                            \Zrcms\ContentCore\Site\Api\Repository\FindSiteVersion::class,
                            ContentVersionToArray::class,
                            ['literal' => 'site-repository-find-content-version']
                        ],
                    ],
                    InsertSiteVersion::class => [
                        'arguments' => [
                            \Zrcms\Content\Api\Repository\InsertContentVersion::class,
                            ContentVersionToArray::class,
                            GetUserIdByRequest::class,
                            ['literal' => SiteVersionBasic::class],
                            ['literal' => 'site-repository-insert-content-version']
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
                            HandleResponseWithExceptionMessage::class
                        ],
                    ],
                    ViewControllerTest::class => [
                        'factory' => ViewControllerTestFactory::class
                    ],
                ],
            ],
            'middleware_pipeline' => [
                'always' => [
                    'middleware' => [
                        ViewController::class => ViewController::class,
                    ],
                ],
            ],
            'routes' => [
                'zrcms.test-render' => [
                    'name' => 'zrcms.test-render',
                    'path' => '/zrcms/test-render',
                    'middleware' => ViewControllerTest::class,
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
                'zrcms.site.repository.find-content-version' => [
                    'name' => 'zrcms.site.repository.find-content-version',
                    'path' => '/zrcms/site/repository/find-content-version/{id}',
                    'middleware' => [
                        FindSiteVersion::class => FindSiteVersion::class
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],
        ];
    }
}
