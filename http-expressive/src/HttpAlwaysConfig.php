<?php

namespace Zrcms\HttpExpressive;

use Zrcms\ContentCore\Site\Api\GetSiteCmsResourceByRequest;
use Zrcms\ContentCore\View\Api\GetViewByRequest;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentRedirect\Api\Repository\FindRedirectCmsResourceBySiteRequestPath;
use Zrcms\HttpExpressive\HttpAlways\ContentRedirect;
use Zrcms\HttpExpressive\HttpAlways\LocaleFromSite;
use Zrcms\HttpExpressive\HttpAlways\ParamLogOut;
use Zrcms\HttpExpressive\HttpAlways\RequestWithOriginalUri;
use Zrcms\HttpExpressive\HttpAlways\RequestWithView;
use Zrcms\HttpExpressive\HttpAlways\RequestWithViewRenderPage;
use Zrcms\HttpExpressive\HttpAlways\SiteExists;
use Zrcms\Locale\Api\SetLocale;
use Zrcms\User\Api\LogOut;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpAlwaysConfig
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
                    ContentRedirect::class => [
                        'arguments' => [
                            GetSiteCmsResourceByRequest::class,
                            FindRedirectCmsResourceBySiteRequestPath::class,
                        ],
                    ],

                    LocaleFromSite::class => [
                        'arguments' => [
                            SetLocale::class,
                            GetSiteCmsResourceByRequest::class
                        ],
                    ],

                    ParamLogOut::class => [
                        'arguments' => [
                            LogOut::class,
                        ],
                    ],

                    RequestWithOriginalUri::class => [],

                    RequestWithViewRenderPage::class => [
                        'arguments' => [
                            GetViewLayoutTags::class,
                            RenderView::class,
                        ],
                    ],

                    RequestWithView::class => [
                        'arguments' => [
                            GetViewByRequest::class,
                        ],
                    ],

                    SiteExists::class => [
                        'arguments' => [
                            GetSiteCmsResourceByRequest::class,
                        ],
                    ],
                ],
            ],
        ];
    }
}
