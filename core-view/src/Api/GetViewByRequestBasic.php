<?php

namespace Zrcms\CoreView\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourceBySitePath;
use Zrcms\CorePage\Exception\PageNotFound;
use Zrcms\CorePage\Model\PageCmsResource;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourceByHost;
use Zrcms\CoreSite\Exception\SiteNotFound;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreTheme\Api\CmsResource\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\CoreTheme\Exception\LayoutNotFound;
use Zrcms\CoreTheme\Exception\ThemeNotFound;
use Zrcms\CoreTheme\Model\LayoutCmsResource;
use Zrcms\CoreView\Api\Render\GetViewLayoutTags;
use Zrcms\CoreView\Fields\FieldsView;
use Zrcms\CoreView\Model\View;
use Zrcms\CoreView\Model\ViewBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewByRequestBasic implements GetViewByRequest
{
    /**
     * @var FindSiteCmsResourceByHost
     */
    protected $findSiteCmsResourceByHost;

    /**
     * @var FindPageCmsResourceBySitePath
     */
    protected $findPageCmsResourceBySitePath;

    /**
     * @var FindLayoutCmsResourceByThemeNameLayoutName
     */
    protected $findLayoutCmsResourceByThemeNameLayoutName;

    /**
     * @var GetLayoutName
     */
    protected $getLayoutName;

    /**
     * @var FindComponent
     */
    protected $findComponent;

    /**
     * @var GetViewLayoutTags
     */
    protected $getViewLayoutTags;

    /**
     * @var BuildView
     */
    protected $buildView;

    /**
     * @param FindSiteCmsResourceByHost                  $findSiteCmsResourceByHost
     * @param FindPageCmsResourceBySitePath              $findPageCmsResourceBySitePath
     * @param FindLayoutCmsResourceByThemeNameLayoutName $findLayoutCmsResourceByThemeNameLayoutName
     * @param GetLayoutName                              $getLayoutName
     * @param FindComponent                         $findComponent
     * @param GetViewLayoutTags                          $getViewLayoutTags
     * @param BuildView                                  $buildView
     */
    public function __construct(
        FindSiteCmsResourceByHost $findSiteCmsResourceByHost,
        FindPageCmsResourceBySitePath $findPageCmsResourceBySitePath,
        FindLayoutCmsResourceByThemeNameLayoutName $findLayoutCmsResourceByThemeNameLayoutName,
        GetLayoutName $getLayoutName,
        FindComponent $findComponent,
        GetViewLayoutTags $getViewLayoutTags,
        BuildView $buildView
    ) {
        $this->findSiteCmsResourceByHost = $findSiteCmsResourceByHost;
        $this->findPageCmsResourceBySitePath = $findPageCmsResourceBySitePath;
        $this->findLayoutCmsResourceByThemeNameLayoutName = $findLayoutCmsResourceByThemeNameLayoutName;
        $this->getLayoutName = $getLayoutName;

        $this->findComponent = $findComponent;
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

        /** @var SiteCmsResource $siteCmsResource */
        $siteCmsResource = $this->findSiteCmsResourceByHost->__invoke(
            $uri->getHost()
        );

        if (empty($siteCmsResource)) {
            throw new SiteNotFound(
                'Site not found for host: (' . $uri->getHost() . ')'
            );
        }

        $themeName = $siteCmsResource->getContentVersion()->getThemeName();

        $themeComponent = $this->findComponent->__invoke(
            'theme',
            $themeName
        );

        if (empty($themeComponent)) {
            throw new ThemeNotFound(
                'Theme not found (' . $themeName . ')'
                . ' for host: (' . $siteCmsResource->getHost() . ')'
                . ' with site ID: (' . (string)$siteCmsResource->getContentVersionId() . ')'
            );
        }

        $path = $uri->getPath();

        /** @var PageCmsResource $pageCmsResource */
        $pageCmsResource = $this->findPageCmsResourceBySitePath->__invoke(
            $siteCmsResource->getId(),
            $path
        );

        if (empty($pageCmsResource)) {
            throw new PageNotFound(
                'Page not found for host: (' . $uri->getHost() . ')'
                . ' and page: (' . $path . ')'
            );
        }

        $siteVersion = $siteCmsResource->getContentVersion();
        $pageVersion = $pageCmsResource->getContentVersion();

        $layoutName = $this->getLayoutName->__invoke(
            $siteVersion,
            $pageVersion
        );

        /** @var LayoutCmsResource $layoutCmsResource */
        $layoutCmsResource = $this->findLayoutCmsResourceByThemeNameLayoutName->__invoke(
            $themeName,
            $layoutName
        );

        if (empty($layoutCmsResource)) {
            throw new LayoutNotFound(
                'Layout not found: (' . $layoutName . ')'
                . ' with theme name: (' . $themeName . ')'
                . ' for site version ID: (' . $siteVersion->getId() . ')'
                . ' and page version ID: (' . $pageVersion->getId() . ')'
            );
        }

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
