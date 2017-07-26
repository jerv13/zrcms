<?php

namespace Zrcms\ContentCore\View\Api\Repository;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResourceBySitePath;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerVersion;
use Zrcms\ContentCore\Page\Exception\PageNotFoundException;
use Zrcms\ContentCore\Page\Model\PageContainerVersion;
use Zrcms\ContentCore\Page\Model\PropertiesPageContainerVersion;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourceByHost;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteVersion;
use Zrcms\ContentCore\Site\Exception\SiteNotFoundException;
use Zrcms\ContentCore\Site\Model\PropertiesSiteVersion;
use Zrcms\ContentCore\Site\Model\Site;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutVersion;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Exception\ThemeNotFoundException;
use Zrcms\ContentCore\Theme\Model\LayoutComponent;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderData;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Model\PropertiesView;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\ContentCore\View\Model\ViewBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindViewByRequestBasic implements FindViewByRequest
{
    /**
     * @var FindSiteCmsResourceByHost
     */
    protected $findSiteCmsResourceByHost;

    /**
     * @var FindSiteVersion
     */
    protected $findSiteVersion;

    /**
     * @var FindPageContainerCmsResourceBySitePath
     */
    protected $findPageContainerCmsResourceBySitePath;

    /**
     * @var FindPageContainerVersion
     */
    protected $findPageContainerVersion;

    /**
     * @var FindLayoutCmsResourceByThemeNameLayoutName
     */
    protected $findLayoutCmsResourceByThemeNameLayoutName;

    /**
     * @var FindLayoutVersion
     */
    protected $findLayoutVersion;

    /**
     * @var FindThemeComponent
     */
    protected $findThemeComponent;

    /**
     * @var GetViewRenderData
     */
    protected $getViewRenderData;

    /**
     * @var RenderView
     */
    protected $renderView;

    /**
     * @param FindSiteCmsResourceByHost                  $findSiteCmsResourceByHost
     * @param FindSiteVersion                            $findSiteVersion
     * @param FindPageContainerCmsResourceBySitePath     $findPageContainerCmsResourceBySitePath
     * @param FindPageContainerVersion                   $findPageContainerVersion
     * @param FindLayoutCmsResourceByThemeNameLayoutName $findLayoutCmsResourceByThemeNameLayoutName
     * @param FindLayoutVersion                          $findLayoutVersion
     * @param FindThemeComponent                         $findThemeComponent
     * @param GetViewRenderData                          $getViewRenderData
     * @param RenderView                                 $renderView
     */
    public function __construct(
        FindSiteCmsResourceByHost $findSiteCmsResourceByHost,
        FindSiteVersion $findSiteVersion,
        FindPageContainerCmsResourceBySitePath $findPageContainerCmsResourceBySitePath,
        FindPageContainerVersion $findPageContainerVersion,
        FindLayoutCmsResourceByThemeNameLayoutName $findLayoutCmsResourceByThemeNameLayoutName,
        FindLayoutVersion $findLayoutVersion,
        FindThemeComponent $findThemeComponent,
        GetViewRenderData $getViewRenderData,
        RenderView $renderView
    ) {
        $this->findSiteCmsResourceByHost = $findSiteCmsResourceByHost;
        $this->findSiteVersion = $findSiteVersion;
        $this->findPageContainerCmsResourceBySitePath = $findPageContainerCmsResourceBySitePath;
        $this->findPageContainerVersion = $findPageContainerVersion;
        $this->findLayoutCmsResourceByThemeNameLayoutName = $findLayoutCmsResourceByThemeNameLayoutName;
        $this->findLayoutVersion = $findLayoutVersion;

        $this->findThemeComponent = $findThemeComponent;
        $this->getViewRenderData = $getViewRenderData;
        $this->renderView = $renderView;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return View
     * @throws PageNotFoundException
     * @throws SiteNotFoundException
     * @throws ThemeNotFoundException
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): View
    {
        $uri = $request->getUri();

        $siteCmsResource = $this->findSiteCmsResourceByHost->__invoke(
            $uri->getHost()
        );

        if (empty($siteCmsResource)) {
            throw new SiteNotFoundException(
                'Site not found for host: ' . $uri->getHost()
            );
        }

        /** @var Site $siteVersion */
        $siteVersion = $this->findSiteVersion->__invoke(
            $siteCmsResource->getContentVersionId()
        );

        $themeName = $siteVersion->getThemeName();

        $theme = $this->findThemeComponent->__invoke(
            $themeName
        );

        if (empty($theme)) {
            throw new ThemeNotFoundException(
                'Theme not found for site: ' . $siteCmsResource->getHost()
            );
        }

        $pageContainerCmsResource = $this->findPageContainerCmsResourceBySitePath->__invoke(
            $siteCmsResource->getId(),
            $uri->getPath()
        );

        if (empty($pageContainerCmsResource)) {
            throw new PageNotFoundException(
                'Page not found for host: ' . $uri->getHost()
                . ' and page: ' . $uri->getPath()
            );
        }

        /** @var PageContainerVersion $pageContainerVersion */
        $pageContainerVersion = $this->findPageContainerVersion->__invoke(
            $pageContainerCmsResource->getContentVersionId()
        );

        $layoutName = $pageContainerVersion->getProperty(
            PropertiesPageContainerVersion::LAYOUT,
            $siteVersion->getProperty(
                PropertiesSiteVersion::LAYOUT,
                LayoutComponent::PRIMARY_NAME
            )
        );

        $layoutCmsResource = $this->findLayoutCmsResourceByThemeNameLayoutName->__invoke(
            $themeName,
            $layoutName
        );

        $layout = $this->findLayoutVersion->__invoke(
            $layoutCmsResource->getContentVersionId()
        );

        $properties = [
            PropertiesView::SITE_CMS_RESOURCE => $siteCmsResource,
            PropertiesView::SITE => $siteVersion,
            PropertiesView::PAGE_CONTAINER_CMS_RESOURCE => $pageContainerCmsResource,
            PropertiesView::PAGE => $pageContainerVersion,
            PropertiesView::LAYOUT_CMS_RESOURCE => $layoutCmsResource,
            PropertiesView::LAYOUT => $layout,
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

        return new ViewBasic(
            $properties
        );
    }
}
