<?php

namespace Zrcms\HttpExpressive1;

use Zrcms\ContentCore\Site\Api\GetSiteCmsResourceByRequest;
use Zrcms\ContentCore\View\Api\GetViewByRequest;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentRedirect\Api\Repository\FindRedirectCmsResourceBySiteRequestPath;
use Zrcms\HttpExpressive1\HttpAlways\ContentRedirect;
use Zrcms\HttpExpressive1\HttpAlways\LocaleFromSite;
use Zrcms\HttpExpressive1\HttpAlways\ParamLogOut;
use Zrcms\HttpExpressive1\HttpAlways\RequestWithOriginalUri;
use Zrcms\HttpExpressive1\HttpAlways\RequestWithView;
use Zrcms\HttpExpressive1\HttpAlways\RequestWithViewRenderPage;
use Zrcms\HttpExpressive1\HttpAlways\SiteExists;
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
