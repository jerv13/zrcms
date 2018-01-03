<?php

namespace Zrcms\CoreView\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CorePage\Model\PageCmsResource;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreTheme\Model\LayoutCmsResource;
use Zrcms\CoreView\Api\Render\GetViewLayoutTags;
use Zrcms\CoreView\Exception\LayoutNotFound;
use Zrcms\CoreView\Exception\PageNotFound;
use Zrcms\CoreView\Exception\SiteNotFound;
use Zrcms\CoreView\Exception\ThemeNotFound;
use Zrcms\CoreView\Fields\FieldsView;
use Zrcms\CoreView\Model\View;
use Zrcms\CoreView\Model\ViewBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewByRequestBasic implements GetViewByRequest
{
    protected $getSiteCmsResource;
    protected $getThemeName;
    protected $getPageCmsResource;
    protected $getLayoutName;
    protected $getLayoutCmsResource;
    protected $getViewLayoutTags;
    protected $buildView;

    /**
     * @param GetSiteCmsResource   $getSiteCmsResource
     * @param GetPageCmsResource   $getPageCmsResource
     * @param GetLayoutCmsResource $getLayoutCmsResource
     * @param GetLayoutName        $getLayoutName
     * @param GetThemeName         $getThemeName
     * @param GetViewLayoutTags    $getViewLayoutTags
     * @param BuildView            $buildView
     */
    public function __construct(
        GetSiteCmsResource $getSiteCmsResource,
        GetThemeName $getThemeName,
        GetPageCmsResource $getPageCmsResource,
        GetLayoutName $getLayoutName,
        GetLayoutCmsResource $getLayoutCmsResource,
        GetViewLayoutTags $getViewLayoutTags,
        BuildView $buildView
    ) {
        $this->getSiteCmsResource = $getSiteCmsResource;
        $this->getThemeName = $getThemeName;
        $this->getPageCmsResource = $getPageCmsResource;
        $this->getLayoutName = $getLayoutName;
        $this->getLayoutCmsResource = $getLayoutCmsResource;
        $this->getViewLayoutTags = $getViewLayoutTags;
        $this->buildView = $buildView;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return View
     * @throws LayoutNotFound
     * @throws PageNotFound
     * @throws SiteNotFound
     * @throws ThemeNotFound
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): View {
        $uri = $request->getUri();

        $siteCmsResource = $this->getSiteCmsResource->__invoke(
            $uri->getHost()
        );

        $themeName = $this->getThemeName->__invoke(
            $siteCmsResource
        );

        $pageCmsResource = $this->getPageCmsResource->__invoke(
            $siteCmsResource->getId(),
            $uri->getPath()
        );

        $siteVersion = $siteCmsResource->getContentVersion();
        $pageVersion = $pageCmsResource->getContentVersion();

        $layoutName = $this->getLayoutName->__invoke(
            $siteVersion,
            $pageVersion
        );

        $layoutCmsResource = $this->getLayoutCmsResource->__invoke(
            $themeName,
            $layoutName
        );

        return $this->buildView(
            $request,
            $siteCmsResource,
            $pageCmsResource,
            $layoutCmsResource,
            $options
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @param SiteCmsResource        $siteCmsResource
     * @param PageCmsResource        $pageCmsResource
     * @param LayoutCmsResource      $layoutCmsResource
     * @param array                  $options
     *
     * @return View
     */
    protected function buildView(
        ServerRequestInterface $request,
        SiteCmsResource $siteCmsResource,
        PageCmsResource $pageCmsResource,
        LayoutCmsResource $layoutCmsResource,
        array $options = []
    ) {
        $properties = [
            FieldsView::SITE_CMS_RESOURCE
            => $siteCmsResource,

            FieldsView::PAGE_CONTAINER_CMS_RESOURCE
            => $pageCmsResource,

            FieldsView::LAYOUT_CMS_RESOURCE
            => $layoutCmsResource,
        ];

        $additionalProperties = Param::get(
            $options,
            self::OPTION_ADDITIONAL_PROPERTIES,
            []
        );

        $properties = array_merge(
            $additionalProperties,
            $properties
        );

        $view = new ViewBasic(
            $properties
        );

        return $this->buildView->__invoke(
            $request,
            $view
        );
    }
}
