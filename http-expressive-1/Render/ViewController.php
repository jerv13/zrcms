<?php

namespace Zrcms\Core\PageView\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Page\Api\Repository\FindPageContainerCmsResourceBySitePath;
use Zrcms\Core\Page\Api\Repository\FindPageContainerVersion;
use Zrcms\Core\Page\Model\PageContainerVersion;
use Zrcms\Core\Page\Model\PropertiesPageContainerVersion;
use Zrcms\Core\Site\Api\Repository\FindSiteCmsResource;
use Zrcms\Core\Site\Api\Repository\FindSiteVersion;
use Zrcms\Core\Site\Model\PropertiesSiteVersion;
use Zrcms\Core\Site\Model\Site;
use Zrcms\Core\Theme\Api\Repository\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\Core\Theme\Api\Repository\FindLayoutVersion;
use Zrcms\Core\Theme\Api\Repository\FindThemeComponent;
use Zrcms\Core\Theme\Model\LayoutComponent;
use Zrcms\Core\View\Api\Render\GetViewRenderData;
use Zrcms\Core\View\Api\Render\RenderView;
use Zrcms\Core\View\Model\PropertiesView;
use Zrcms\Core\View\Model\ViewBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ViewController
{
    protected $buildCmsUri;

    public function __construct(
        FindSiteCmsResource $findSiteCmsResource,
        FindSiteVersion $findSiteVersion,
        FindPageContainerCmsResourceBySitePath $findPageContainerCmsResourceBySitePath,
        FindPageContainerVersion $findPageContainerVersion,
        FindLayoutCmsResourceByThemeNameLayoutName $findLayoutCmsResourceByThemeNameLayoutName,
        FindLayoutVersion $findLayoutVersion,
        FindThemeComponent $findThemeComponent,
        GetViewRenderData $getViewRenderData,
        RenderView $renderView
    ) {
        $this->findSiteCmsResource = $findSiteCmsResource;
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
        $uri = $request->getUri();

        $siteCmsResource = $this->findSiteCmsResource->__invoke(
            $uri->getHost()
        );

        if (empty($siteCmsResource)) {
            return $response->withStatus(404, 'SITE NOT FOUND');
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
            throw new \Exception(
                'Theme not found for site: ' . $siteCmsResource->getHost()
            );
        }

        $pageContainerCmsResource = $this->findPageContainerCmsResourceBySitePath->__invoke(
            $siteCmsResource->getId(),
            $uri->getHost()
        );

        if (empty($pageContainerCmsResource)) {
            return $response->withStatus(404, 'PAGE NOT FOUND');
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

        $pageView = new ViewBasic(
            [
                PropertiesView::SITE_CMS_RESOURCE => $siteCmsResource,
                PropertiesView::SITE => $siteVersion,
                PropertiesView::PAGE_CONTAINER_CMS_RESOURCE => $pageContainerCmsResource,
                PropertiesView::PAGE => $pageContainerVersion,
                PropertiesView::LAYOUT_CMS_RESOURCE => $layoutCmsResource,
                PropertiesView::LAYOUT => $layout,
            ]
        );

        $viewRenderData = $this->getViewRenderData->__invoke(
            $pageView,
            $request
        );

        $this->renderView->__invoke(
            $pageView,
            $viewRenderData
        );


        return $response->withBody(

        );
    }
}
