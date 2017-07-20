<?php

namespace Zrcms\Core\PageView\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Page\Api\Repository\FindPageCmsResource;
use Zrcms\Core\PageView\Api\Render\RenderPageView;
use Zrcms\Core\PageView\Model\PageViewBasic;
use Zrcms\Core\PageView\Model\PageViewProperties;
use Zrcms\Core\Site\Api\Repository\FindSiteCmsResource;
use Zrcms\Core\Theme\Api\Repository\FindTheme;
use Zrcms\Core\Theme\Model\Layout;
use Zrcms\Core\ThemeLayout\Api\Repository\FindThemeLayoutCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PageViewController
{
    protected $buildCmsUri;

    public function __construct(
        FindSiteCmsResource $findSiteCmsResource,
        FindTheme $findTheme,
        FindPageCmsResource $findPageCmsResource,
        FindThemeLayoutCmsResource $findThemeLayoutCmsResource,
        RenderPageView $renderPageView
    ) {
        $this->findSiteCmsResource = $findSiteCmsResource;
        $this->findTheme = $findTheme;
        $this->findPageCmsResource = $findPageCmsResource;
        $this->findThemeLayoutCmsResource = $findThemeLayoutCmsResource;
        $this->renderPageView = $renderPageView;
    }

    /**
     * __invoke
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $id = $request->getUri();

        $siteCmsResource = $this->findSiteCmsResource->__invoke(
            $id->getHost()
        );

        if (empty($siteCmsResource)) {
            return $response->withStatus(404, 'SITE NOT FOUND');
        }

        /** @var Site $site */
        $site = $siteCmsResource->getContent();
        $themeName = $site->getThemeName();

        $theme = $this->findTheme->__invoke(
            $themeName
        );

        if (empty($theme)) {
            throw new \Exception(
                'Theme not found for site: ' . $site->getHost()
            );
        }

        $pageUri = $this->buildPageUri->__invoke(
            $site->getId(),
            $id->getPath()
        );

        $pageCmsResource = $this->findPageCmsResource->__invoke(
            $pageUri
        );

        if (empty($pageCmsResource)) {
            return $response->withStatus(404, 'PAGE NOT FOUND');
        }

        /** @var Page $page */
        $page = $pageCmsResource->getContent();

        $layoutName = $page->getProperty(
            PageProperties::LAYOUT,
            $site->getProperty(
                SiteProperties::LAYOUT,
                Layout::DEFAULT_NAME
            )
        );

        $themeLayoutUri = $this->buildThemeLayoutUri->__invoke(
            $theme->getName(),
            $layoutName,
            $site->getId()
        );

        $layoutCmsResource = $this->findThemeLayoutCmsResource->__invoke(
            $themeLayoutUri
        );

        $layout = $layoutCmsResource->getContent();

        $theme->getLayout(
            $layoutName,
            $theme->getDefaultLayout()
        );

        $pageView = new PageViewBasic(
            [
                PageViewProperties::SITE_CMS_RESOURCE => $siteCmsResource,
                PageViewProperties::PAGE_CMS_RESOURCE => $pageCmsResource,
                PageViewProperties::THEME => $theme,
                PageViewProperties::LAYOUT_CMS_RESOURCE => $la
            ]
        );

        // get page layout
        // get site layout in no page layout

        $this->renderPageView->__invoke()

        $this->renderLayoutCmsResource->__invoke(
            $layout
        );
    }

    public function renderCmsLayout(
        Site $site,
        string $html
    ) {
        $site = findSite('host');

        $page = findPage('path' and $site->id);

        $containers = findContainers();


    }
}
