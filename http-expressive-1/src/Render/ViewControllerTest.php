<?php

namespace Zrcms\ContentCore\PageView\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\ContentCore\Page\Api\Render\GetPageContainerRenderDataHtml;
use Zrcms\ContentCore\Page\Api\Render\RenderPageContainerRows;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResourceBasic;
use Zrcms\ContentCore\Page\Model\PageContainerVersionBasic;
use Zrcms\ContentCore\Page\Model\PropertiesPageContainerCmsResource;
use Zrcms\ContentCore\Page\Model\PropertiesPageContainerVersion;
use Zrcms\ContentCore\Site\Model\PropertiesSiteCmsResource;
use Zrcms\ContentCore\Site\Model\PropertiesSiteVersion;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceBasic;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\ContentCore\Theme\Api\Render\GetLayoutRenderDataNoop;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayoutMustache;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResourceBasic;
use Zrcms\ContentCore\Theme\Model\LayoutVersionBasic;
use Zrcms\ContentCore\Theme\Model\PropertiesLayoutCmsResource;
use Zrcms\ContentCore\Theme\Model\PropertiesLayoutVersion;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderData;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Api\Repository\FindTagNamesByLayout;
use Zrcms\ContentCore\View\Model\PropertiesView;
use Zrcms\ContentCore\View\Model\ViewBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ViewControllerTest
{
    /**
     * @param GetViewRenderData $getViewRenderData
     * @param RenderView        $renderView
     */
    public function __construct(
        GetViewRenderData $getViewRenderData,
        RenderView $renderView
    ) {
        $this->getViewRenderData = $getViewRenderData;
        $this->renderView = $renderView;
    }

    /**
     * __invoke
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        die('here');
        $additionalViewProperties = [];

        $siteCmsResource = new SiteCmsResourceBasic(
            [
                PropertiesSiteCmsResource::ID
                => 'test:' . PropertiesSiteCmsResource::ID,
                PropertiesSiteCmsResource::CONTENT_VERSION_ID
                => 'test:' . PropertiesSiteCmsResource::CONTENT_VERSION_ID,
                PropertiesSiteCmsResource::HOST
                => 'test:' . PropertiesSiteCmsResource::HOST,
            ],
            'test-user-id',
            'test-reason'
        );

        $siteVersion = new SiteVersionBasic(
            [
                PropertiesSiteVersion::ID
                => 'test:' . PropertiesSiteVersion::ID,
                PropertiesSiteVersion::COUNTRY_ISO3
                => 'test:' . PropertiesSiteVersion::COUNTRY_ISO3,
                PropertiesSiteVersion::FAVICON
                => 'test:' . PropertiesSiteVersion::FAVICON,
                PropertiesSiteVersion::LANGUAGE_ISO_939_2T
                => 'test:' . PropertiesSiteVersion::LANGUAGE_ISO_939_2T,
                PropertiesSiteVersion::LAYOUT
                => 'test:' . PropertiesSiteVersion::LAYOUT,
                PropertiesSiteVersion::LOCALE
                => 'test:' . PropertiesSiteVersion::LOCALE,
                PropertiesSiteVersion::LOGIN_PAGE
                => 'test:' . PropertiesSiteVersion::LOGIN_PAGE,
                PropertiesSiteVersion::NOT_AUTHORIZED_PAGE
                => 'test:' . PropertiesSiteVersion::NOT_AUTHORIZED_PAGE,
                PropertiesSiteVersion::NOT_FOUND_PAGE
                => 'test:' . PropertiesSiteVersion::NOT_FOUND_PAGE,
                PropertiesSiteVersion::THEME_NAME
                => 'test:' . PropertiesSiteVersion::THEME_NAME,
                PropertiesSiteVersion::TITLE
                => 'test:' . PropertiesSiteVersion::TITLE,
            ],
            'test-user-id',
            'test-reason'
        );

        $pageContainerCmsResource = new PageContainerCmsResourceBasic(
            [
                PropertiesPageContainerCmsResource::ID
                => 'test:' . PropertiesPageContainerCmsResource::ID,
                PropertiesPageContainerCmsResource::CONTENT_VERSION_ID
                => 'test:' . PropertiesPageContainerCmsResource::CONTENT_VERSION_ID,
                PropertiesPageContainerCmsResource::SITE_CMS_RESOURCE_ID
                => 'test:' . PropertiesPageContainerCmsResource::SITE_CMS_RESOURCE_ID,
                PropertiesPageContainerCmsResource::PATH
                => 'test:' . PropertiesPageContainerCmsResource::PATH,
            ],
            'test-user-id',
            'test-reason'
        );

        $pageContainerVersion = new PageContainerVersionBasic(
            [
                PropertiesPageContainerVersion::ID
                => 'test:' . PropertiesPageContainerVersion::ID,
                PropertiesPageContainerVersion::TITLE
                => 'test:' . PropertiesPageContainerVersion::TITLE,
                PropertiesPageContainerVersion::DESCRIPTION
                => 'test:' . PropertiesPageContainerVersion::DESCRIPTION,
                PropertiesPageContainerVersion::KEYWORDS
                => 'test:' . PropertiesPageContainerVersion::KEYWORDS,
                PropertiesPageContainerVersion::LAYOUT
                => 'test:' . PropertiesPageContainerVersion::LAYOUT,
                PropertiesPageContainerVersion::PRE_RENDERED_HTML
                => 'test:' . PropertiesPageContainerVersion::PRE_RENDERED_HTML,
                PropertiesPageContainerVersion::RENDER_DATA_GETTER
                => GetPageContainerRenderDataHtml::class,
                PropertiesPageContainerVersion::RENDERER
                => RenderPageContainerRows::class,
            ],
            'test-user-id',
            'test-reason'
        );

        $layoutCmsResource = new LayoutCmsResourceBasic(
            [
                PropertiesLayoutCmsResource::ID
                => 'test:' . PropertiesLayoutCmsResource::ID,
                PropertiesLayoutCmsResource::CONTENT_VERSION_ID
                => 'test:' . PropertiesLayoutCmsResource::CONTENT_VERSION_ID,
                PropertiesLayoutCmsResource::NAME
                => 'test:' . PropertiesLayoutCmsResource::NAME,
                PropertiesLayoutCmsResource::THEME_NAME
                => 'test:' . PropertiesLayoutCmsResource::THEME_NAME,
            ],
            'test-user-id',
            'test-reason'
        );

        $layout = new LayoutVersionBasic(
            [
                PropertiesLayoutVersion::ID
                => 'test:' . PropertiesLayoutVersion::ID,
                PropertiesLayoutVersion::NAME
                => 'test:' . PropertiesLayoutVersion::NAME,
                PropertiesLayoutVersion::THEME_NAME
                => 'test:' . PropertiesLayoutVersion::THEME_NAME,
                PropertiesLayoutVersion::HTML
                => 'test:' . PropertiesLayoutVersion::HTML,
                PropertiesLayoutVersion::RENDER_DATA_GETTER
                => GetLayoutRenderDataNoop::class,
                PropertiesLayoutVersion::RENDER_TAG_NAME_PARSER
                => FindTagNamesByLayout::class,
                PropertiesLayoutVersion::RENDERER
                => RenderLayoutMustache::class,
            ],
            'test-user-id',
            'test-reason'
        );

        $properties = [
            PropertiesView::SITE_CMS_RESOURCE => $siteCmsResource,
            PropertiesView::SITE => $siteVersion,
            PropertiesView::PAGE_CONTAINER_CMS_RESOURCE => $pageContainerCmsResource,
            PropertiesView::PAGE => $pageContainerVersion,
            PropertiesView::LAYOUT_CMS_RESOURCE => $layoutCmsResource,
            PropertiesView::LAYOUT => $layout,
        ];

        $additionalProperties = [
            'some-test' => 'test'
        ];

        $properties = array_merge(
            $additionalProperties,
            $properties
        );

        $pageView = new ViewBasic(
            $properties
        );

        $viewRenderData = $this->getViewRenderData->__invoke(
            $pageView,
            $request
        );

        $html = $this->renderView->__invoke(
            $pageView,
            $viewRenderData
        );

        return new HtmlResponse($html);
    }
}
