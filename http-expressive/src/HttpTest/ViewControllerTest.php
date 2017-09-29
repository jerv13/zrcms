<?php

namespace Zrcms\HttpExpressive\HttpTest;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\Content\Api\CmsResourceToArray;
use Zrcms\ContentCore\Basic\Api\Repository\FindBasicComponent;
use Zrcms\ContentCore\Page\Api\Render\GetPageContainerRenderTagsHtml;
use Zrcms\ContentCore\Page\Api\Render\RenderPageContainerRows;
use Zrcms\ContentCore\Page\Fields\FieldsPageContainerCmsResource;
use Zrcms\ContentCore\Page\Fields\FieldsPageContainerVersion;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResourceBasic;
use Zrcms\ContentCore\Page\Model\PageContainerVersionBasic;
use Zrcms\ContentCore\Site\Api\Action\PublishSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Repository\InsertSiteVersion;
use Zrcms\ContentCore\Site\Fields\FieldsSiteCmsResource;
use Zrcms\ContentCore\Site\Fields\FieldsSiteVersion;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceBasic;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\ContentCore\Theme\Api\Render\GetLayoutRenderTagsNoop;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayoutMustache;
use Zrcms\ContentCore\Theme\Fields\FieldsLayoutCmsResource;
use Zrcms\ContentCore\Theme\Fields\FieldsLayoutVersion;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResourceBasic;
use Zrcms\ContentCore\Theme\Model\LayoutVersionBasic;
use Zrcms\ContentCore\View\Api\GetTagNamesByLayoutMustache;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Fields\FieldsView;
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
                FieldsSiteCmsResource::CONTENT_VERSION
                => $newSiteVersion,
                FieldsSiteCmsResource::HOST
                => 'test:' . FieldsSiteCmsResource::HOST,
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
            ],
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON
        );

        $siteCmsResource = new SiteCmsResourceBasic(
            'testID',
            true,
            $siteVersion,
            [
                FieldsSiteCmsResource::HOST
                => 'test:' . FieldsSiteCmsResource::HOST,
            ],
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON
        );

        $pageContainerVersion = new PageContainerVersionBasic(
            'testID',
            [
                FieldsPageContainerVersion::TITLE
                => 'test:' . FieldsPageContainerVersion::TITLE,
                FieldsPageContainerVersion::DESCRIPTION
                => 'test:' . FieldsPageContainerVersion::DESCRIPTION,
                FieldsPageContainerVersion::KEYWORDS
                => 'test:' . FieldsPageContainerVersion::KEYWORDS,
                FieldsPageContainerVersion::LAYOUT
                => 'test:' . FieldsPageContainerVersion::LAYOUT,
                FieldsPageContainerVersion::PRE_RENDERED_HTML
                => 'test:' . FieldsPageContainerVersion::PRE_RENDERED_HTML,
                FieldsPageContainerVersion::RENDER_TAGS_GETTER
                => GetPageContainerRenderTagsHtml::class,
                FieldsPageContainerVersion::RENDERER
                => RenderPageContainerRows::class,
            ],
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON
        );

        $pageContainerCmsResource = new PageContainerCmsResourceBasic(
            'testID',
            true,
            $pageContainerVersion,
            [
                FieldsPageContainerCmsResource::SITE_CMS_RESOURCE_ID
                => 'test:' . FieldsPageContainerCmsResource::SITE_CMS_RESOURCE_ID,
                FieldsPageContainerCmsResource::PATH
                => '/test-' . FieldsPageContainerCmsResource::PATH,
            ],
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON
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
            ],
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON
        );

        $layoutCmsResource = new LayoutCmsResourceBasic(
            'testID',
            true,
            $layout,
            [
                FieldsLayoutCmsResource::NAME
                => 'test:' . FieldsLayoutCmsResource::NAME,
                FieldsLayoutCmsResource::THEME_NAME
                => 'test:' . FieldsLayoutCmsResource::THEME_NAME,
            ],
            self::CREATED_BY_USER_ID,
            self::CREATED_REASON
        );

        $properties = [
            FieldsView::SITE_CMS_RESOURCE => $siteCmsResource,
            FieldsView::PAGE_CONTAINER_CMS_RESOURCE => $pageContainerCmsResource,
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
