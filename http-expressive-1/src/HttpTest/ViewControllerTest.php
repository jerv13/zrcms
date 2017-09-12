<?php

namespace Zrcms\HttpExpressive1\HttpTest;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\Content\Api\CmsResourceToArray;
use Zrcms\ContentCore\Basic\Api\Repository\FindBasicComponent;
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
use Zrcms\ContentCore\View\Api\GetTagNamesByLayoutMustache;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Model\PropertiesView;
use Zrcms\ContentCore\View\Model\ViewBasic;

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
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return JsonResponse
     */
    public function test(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        /** @var FindBasicComponent $find */
        $find = $this->serviceContainer->get(FindBasicComponent::class);
        $result = $find->__invoke(
            'zrcms-countries'
        );

        ddd(
            $result
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
                PropertiesSiteVersion::STATUS_PAGES => [],
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
                PropertiesSiteCmsResource::CONTENT_VERSION
                => $newSiteVersion,
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

        /** @var CmsResourceToArray $toArray */
        $toArray = $this->serviceContainer->get(CmsResourceToArray::class);

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
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $additionalViewProperties = [];

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
                PropertiesSiteVersion::STATUS_PAGES => [],
                PropertiesSiteVersion::THEME_NAME
                => 'test:' . PropertiesSiteVersion::THEME_NAME,
                PropertiesSiteVersion::TITLE
                => 'test:' . PropertiesSiteVersion::TITLE,
            ],
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON
        );

        $siteCmsResource = new SiteCmsResourceBasic(
            [
                PropertiesSiteCmsResource::ID
                => 'test:' . PropertiesSiteCmsResource::ID,
                PropertiesSiteCmsResource::CONTENT_VERSION
                => $siteVersion,
                PropertiesSiteCmsResource::HOST
                => 'test:' . PropertiesSiteCmsResource::HOST,
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

        $pageContainerCmsResource = new PageContainerCmsResourceBasic(
            [
                PropertiesPageContainerCmsResource::ID
                => 'test:' . PropertiesPageContainerCmsResource::ID,
                PropertiesPageContainerCmsResource::CONTENT_VERSION
                => $pageContainerVersion,
                PropertiesPageContainerCmsResource::SITE_CMS_RESOURCE_ID
                => 'test:' . PropertiesPageContainerCmsResource::SITE_CMS_RESOURCE_ID,
                PropertiesPageContainerCmsResource::PATH
                => '/test-' . PropertiesPageContainerCmsResource::PATH,
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
                => file_get_contents(__DIR__ . '/../../../xample-component/theme/layout/primary/template.mustache'),
                PropertiesLayoutVersion::RENDER_TAGS_GETTER
                => GetLayoutRenderTagsNoop::class,
                PropertiesLayoutVersion::RENDER_TAG_NAME_PARSER
                => GetTagNamesByLayoutMustache::class,
                PropertiesLayoutVersion::RENDERER
                => RenderLayoutMustache::class,
            ],
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON
        );

        $layoutCmsResource = new LayoutCmsResourceBasic(
            [
                PropertiesLayoutCmsResource::ID
                => 'test:' . PropertiesLayoutCmsResource::ID,
                PropertiesLayoutCmsResource::CONTENT_VERSION
                => $layout,
                PropertiesLayoutCmsResource::NAME
                => 'test:' . PropertiesLayoutCmsResource::NAME,
                PropertiesLayoutCmsResource::THEME_NAME
                => 'test:' . PropertiesLayoutCmsResource::THEME_NAME,
            ],
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON
        );

        $properties = [
            PropertiesView::ID => 'test:' . PropertiesView::ID,
            PropertiesView::SITE_CMS_RESOURCE => $siteCmsResource,
            PropertiesView::PAGE_CONTAINER_CMS_RESOURCE => $pageContainerCmsResource,
            PropertiesView::LAYOUT_CMS_RESOURCE => $layoutCmsResource,
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

        $viewRenderTags = $this->serviceContainer->get(GetViewLayoutTags::class)->__invoke(
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
