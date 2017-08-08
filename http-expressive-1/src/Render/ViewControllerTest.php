<?php

namespace Zrcms\HttpExpressive1\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\Content\Api\CsmResourceToArray;
use Zrcms\ContentCore\Page\Api\Render\GetPageContainerRenderTagsHtml;
use Zrcms\ContentCore\Page\Api\Render\RenderPageContainerRows;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResourceBasic;
use Zrcms\ContentCore\Page\Model\PageContainerVersionBasic;
use Zrcms\ContentCore\Page\Model\PropertiesPageContainerCmsResource;
use Zrcms\ContentCore\Page\Model\PropertiesPageContainerVersion;
use Zrcms\ContentCore\Site\Api\Action\PublishSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Repository\InsertSiteVersion;
use Zrcms\ContentCore\Site\Model\PropertiesSiteCmsResource;
use Zrcms\ContentCore\Site\Model\PropertiesSiteVersion;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceBasic;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\ContentCore\Theme\Api\Render\GetLayoutRenderTagsNoop;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayoutMustache;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResourceBasic;
use Zrcms\ContentCore\Theme\Model\LayoutVersionBasic;
use Zrcms\ContentCore\Theme\Model\PropertiesLayoutCmsResource;
use Zrcms\ContentCore\Theme\Model\PropertiesLayoutVersion;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderTags;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Api\Repository\FindTagNamesByLayoutMustache;
use Zrcms\ContentCore\View\Model\PropertiesView;
use Zrcms\ContentCore\View\Model\ViewBasic;
use Zrcms\ContentCore\ViewLayoutTags\Api\Repository\FindViewLayoutTagsComponent;
use Zrcms\ContentCore\ViewLayoutTags\Api\Repository\FindViewLayoutTagsComponentsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ViewControllerTest
{
    const CREATED_BY_USER_ID = 'test-user-id';
    const CREATED_REASON = 'test-reason';

    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @param ContainerInterface $serviceContainer
     */
    public function __construct(
        $serviceContainer
    ) {
        $this->serviceContainer = $serviceContainer;
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

        /** @var FindViewLayoutTagsComponent $s */
        $s = $this->serviceContainer->get(FindViewLayoutTagsComponent::class);

        ddd(
            $s->__invoke('head-all')
        );

        $siteVersion = new SiteVersionBasic(
            [
                PropertiesSiteVersion::COUNTRY_ISO3
                => 'test1:' . PropertiesSiteVersion::COUNTRY_ISO3,
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
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON
        );

        /** @var InsertSiteVersion $insertSiteVersion */
        $insertSiteVersion = $this->serviceContainer->get(InsertSiteVersion::class);

        $newSiteVersion = $insertSiteVersion->__invoke(
            $siteVersion
        );

        $siteCmsResource = new SiteCmsResourceBasic(
            [
                PropertiesSiteCmsResource::CONTENT_VERSION_ID
                => $newSiteVersion->getId(),
                PropertiesSiteCmsResource::HOST
                => 'test:' . PropertiesSiteCmsResource::HOST,
            ],
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON
        );

        /** @var PublishSiteCmsResource $publishSiteCmsResource */
        $publishSiteCmsResource = $this->serviceContainer->get(PublishSiteCmsResource::class);

        $newSiteCmsResource = $publishSiteCmsResource->__invoke(
            $siteCmsResource,
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON
        );

        /** @var CsmResourceToArray $toArray */
        $toArray = $this->serviceContainer->get(CsmResourceToArray::class);

        return new JsonResponse(
            $toArray->__invoke($newSiteCmsResource)
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return HtmlResponse
     */
    public function renderBasicView(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
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
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON
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
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON
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
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON
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
                PropertiesPageContainerVersion::RENDER_TAGS_GETTER
                => GetPageContainerRenderTagsHtml::class,
                PropertiesPageContainerVersion::RENDERER
                => RenderPageContainerRows::class,
            ],
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON
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
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON
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
                => file_get_contents(__DIR__ . '/../../../xample-module/theme/default.mustache'),
                PropertiesLayoutVersion::RENDER_TAGS_GETTER
                => GetLayoutRenderTagsNoop::class,
                PropertiesLayoutVersion::RENDER_TAG_NAME_PARSER
                => FindTagNamesByLayoutMustache::class,
                PropertiesLayoutVersion::RENDERER
                => RenderLayoutMustache::class,
            ],
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON
        );

        $properties = [
            PropertiesView::ID => 'test:' . PropertiesView::ID,
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

        $viewRenderTags = $this->serviceContainer->get(GetViewRenderTags::class)->__invoke(
            $pageView,
            $request
        );

        $html = $this->serviceContainer->get(RenderView::class)->__invoke(
            $pageView,
            $viewRenderTags
        );

        return new HtmlResponse($html);
    }
}
