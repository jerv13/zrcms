<?php

namespace Zrcms\HttpTest\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router\RouteResult;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\CorePage\Api\Render\GetPageRenderTagsHtml;
use Zrcms\CorePage\Fields\FieldsPageVersion;
use Zrcms\CorePage\Model\PageCmsResourceBasic;
use Zrcms\CorePage\Model\PageVersionBasic;
use Zrcms\CoreSite\Api\CmsResource\UpsertSiteCmsResource;
use Zrcms\CoreSite\Api\Content\InsertSiteVersion;
use Zrcms\CoreSite\Fields\FieldsSiteVersion;
use Zrcms\CoreSite\Model\SiteCmsResourceBasic;
use Zrcms\CoreSite\Model\SiteVersionBasic;
use Zrcms\CoreTheme\Api\Render\GetLayoutRenderTagsNoop;
use Zrcms\CoreTheme\Api\Render\RenderLayoutMustache;
use Zrcms\CoreTheme\Fields\FieldsLayoutVersion;
use Zrcms\CoreTheme\Model\LayoutCmsResourceBasic;
use Zrcms\CoreTheme\Model\LayoutVersionBasic;
use Zrcms\CoreView\Api\GetTagNamesByLayoutMustache;
use Zrcms\CoreView\Api\Render\GetViewLayoutTags;
use Zrcms\CoreView\Api\Render\RenderView;
use Zrcms\CoreView\Fields\FieldsView;
use Zrcms\CoreView\Model\ViewBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpViewTest
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
        /** @var FindComponent $find */
        $find = $this->serviceContainer->get(FindComponent::class);
        $result = $find->__invoke(
            'basic',
            'zrcms-countries'
        );

        ddd(
            $result
        );

        $siteVersion = new SiteVersionBasic(
            'testId',
            [
                FieldsSiteVersion::COUNTRY_ISO3
                => 'test1:' . FieldsSiteVersion::COUNTRY_ISO3,
                FieldsSiteVersion::FAVICON
                => 'test:' . FieldsSiteVersion::FAVICON,
                FieldsSiteVersion::LANGUAGE_ISO_939_2T
                => 'test:' . FieldsSiteVersion::LANGUAGE_ISO_939_2T,
                FieldsSiteVersion::LAYOUT
                => 'test:' . FieldsSiteVersion::LAYOUT,
                FieldsSiteVersion::LOCALE
                => 'test:' . FieldsSiteVersion::LOCALE,
                FieldsSiteVersion::LOGIN_PAGE
                => 'test:' . FieldsSiteVersion::LOGIN_PAGE,
                FieldsSiteVersion::STATUS_PAGES => [],
                FieldsSiteVersion::THEME_NAME
                => 'test:' . FieldsSiteVersion::THEME_NAME,
                FieldsSiteVersion::TITLE
                => 'test:' . FieldsSiteVersion::TITLE,
                FieldsSiteVersion::HOST
                => 'test:' . FieldsSiteVersion::HOST,
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
            'testId',
            true,
            $newSiteVersion,
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON
        );

        /** @var UpsertSiteCmsResource $upsertSiteCmsResource */
        $upsertSiteCmsResource = $this->serviceContainer->get(UpsertSiteCmsResource::class);

        $newSiteCmsResource = $upsertSiteCmsResource->__invoke(
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
        /** @var RouteResult $routeResult */
        $routeResult = $request->getAttribute(RouteResult::class);

        $route = $routeResult->getMatchedRoute();

        var_dump(
            $route->getOptions()
        );
        die;

        $siteVersion = new SiteVersionBasic(
            'testID',
            [
                FieldsSiteVersion::COUNTRY_ISO3
                => 'test:' . FieldsSiteVersion::COUNTRY_ISO3,
                FieldsSiteVersion::FAVICON
                => 'test:' . FieldsSiteVersion::FAVICON,
                FieldsSiteVersion::LANGUAGE_ISO_939_2T
                => 'test:' . FieldsSiteVersion::LANGUAGE_ISO_939_2T,
                FieldsSiteVersion::LAYOUT
                => 'test:' . FieldsSiteVersion::LAYOUT,
                FieldsSiteVersion::LOCALE
                => 'test:' . FieldsSiteVersion::LOCALE,
                FieldsSiteVersion::LOGIN_PAGE
                => 'test:' . FieldsSiteVersion::LOGIN_PAGE,
                FieldsSiteVersion::STATUS_PAGES => [],
                FieldsSiteVersion::THEME_NAME
                => 'test:' . FieldsSiteVersion::THEME_NAME,
                FieldsSiteVersion::TITLE
                => 'test:' . FieldsSiteVersion::TITLE,
                FieldsSiteVersion::HOST
                => '/test/' . FieldsSiteVersion::HOST,
            ],
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON,
            null
        );

        $siteCmsResource = new SiteCmsResourceBasic(
            'testID',
            true,
            $siteVersion,
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON,
            null
        );

        $pageVersion = new PageVersionBasic(
            'testID',
            [
                FieldsPageVersion::TITLE
                => 'test:' . FieldsPageVersion::TITLE,
                FieldsPageVersion::DESCRIPTION
                => 'test:' . FieldsPageVersion::DESCRIPTION,
                FieldsPageVersion::KEYWORDS
                => 'test:' . FieldsPageVersion::KEYWORDS,
                FieldsPageVersion::LAYOUT
                => 'test:' . FieldsPageVersion::LAYOUT,
                FieldsPageVersion::PRE_RENDERED_HTML
                => 'test:' . FieldsPageVersion::PRE_RENDERED_HTML,
                FieldsPageVersion::RENDER_TAGS_GETTER
                => GetPageRenderTagsHtml::class,
                FieldsPageVersion::SITE_CMS_RESOURCE_ID
                => 'test:' . FieldsPageVersion::SITE_CMS_RESOURCE_ID,
                FieldsPageVersion::PATH
                => '/test-' . FieldsPageVersion::PATH,
            ],
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON,
            null
        );

        $pageCmsResource = new PageCmsResourceBasic(
            'testID',
            true,
            $pageVersion,
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON,
            null
        );

        $layout = new LayoutVersionBasic(
            'testID',
            [
                FieldsLayoutVersion::NAME
                => 'test:' . FieldsLayoutVersion::NAME,
                FieldsLayoutVersion::THEME_NAME
                => 'test:' . FieldsLayoutVersion::THEME_NAME,
                FieldsLayoutVersion::HTML
                => file_get_contents(__DIR__ . '/../../../xample-component/theme/layout/primary/template.mustache'),
                FieldsLayoutVersion::RENDER_TAGS_GETTER
                => GetLayoutRenderTagsNoop::class,
                FieldsLayoutVersion::RENDER_TAG_NAME_PARSER
                => GetTagNamesByLayoutMustache::class,
                FieldsLayoutVersion::RENDERER
                => RenderLayoutMustache::class,
                FieldsLayoutVersion::NAME
                => 'test:' . FieldsLayoutVersion::NAME,
                FieldsLayoutVersion::THEME_NAME
                => 'test:' . FieldsLayoutVersion::THEME_NAME,
            ],
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON,
            null
        );

        $layoutCmsResource = new LayoutCmsResourceBasic(
            'testID',
            true,
            $layout,
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON,
            null
        );

        $properties = [
            FieldsView::SITE_CMS_RESOURCE => $siteCmsResource,
            FieldsView::PAGE_CONTAINER_CMS_RESOURCE => $pageCmsResource,
            FieldsView::LAYOUT_CMS_RESOURCE => $layoutCmsResource,
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
