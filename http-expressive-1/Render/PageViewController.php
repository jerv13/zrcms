<?php

namespace Zrcms\Core\PageView\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Container\Api\BuildContainerUri;
use Zrcms\Core\Container\Api\BuildThemeLayoutUri;
use Zrcms\Core\Page\Api\BuildPageUri;
use Zrcms\Core\Page\Api\Repository\FindPageCmsResource;
use Zrcms\Core\Page\Model\Page;
use Zrcms\Core\Page\Model\PageBasic;
use Zrcms\Core\Page\Model\PageProperties;
use Zrcms\Core\PageView\Api\Render\RenderPageView;
use Zrcms\Core\PageView\Model\PageViewBasic;
use Zrcms\Core\PageView\Model\PageViewProperties;
use Zrcms\Core\Site\Api\Repository\FindSiteCmsResource;
use Zrcms\Core\Site\Model\Site;
use Zrcms\Core\Site\Model\SiteProperties;
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
        BuildPageUri $buildPageUri,
        BuildContainerUri $buildContainerUri,
        BuildThemeLayoutUri $buildThemeLayoutUri,
        RenderPageView $renderPageView
    ) {
        $this->findSiteCmsResource = $findSiteCmsResource;
        $this->findTheme = $findTheme;
        $this->findPageCmsResource = $findPageCmsResource;
        $this->findThemeLayoutCmsResource = $findThemeLayoutCmsResource;
        $this->buildPageUri = $buildPageUri;
        $this->buildContainerUri = $buildContainerUri;
        $this->buildThemeLayoutUri = $buildThemeLayoutUri
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
        $uri = $request->getUri();

        $siteCmsResource = $this->findSiteCmsResource->__invoke(
            $uri->getHost()
        );

        if (empty($siteCmsResource)) {
            return $response->withStatus(404, 'SITE NOT FOUND');
        }

        /** @var Site $site */
        $site = $siteCmsResource->getContent();

        $pageUri = $this->buildPageUri->__invoke(
            $site->getId(),
            $uri->getPath()
        );

        $pageCmsResource = $this->findPageCmsResource->__invoke(
            $pageUri
        );

        if (empty($pageCmsResource)) {
            return $response->withStatus(404, 'PAGE NOT FOUND');
        }

        /** @var Page $page */
        $page = $pageCmsResource->getContent();

        $theme = $this->findTheme->__invoke(
            $site->getThemeName()
        );

        if (empty($theme)) {
            // @todo throw
            return $response->withStatus(404, 'SITE THEME NOT FOUND');
        }

        $layoutName = $page->getProperty(
            PageProperties::LAYOUT,
            $site->getProperty(
                SiteProperties::LAYOUT,
                Layout::DEFAULT_NAME
            )
        );

        $themeLayoutUri = $this->buildThemeLayoutUri->__invoke(
            $site->getId(),
            $layoutName,
            $layoutName
        );

        $themeLayoutUri

        $layout = $theme->getLayout(
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
        $theme = $this->findTheme->__invoke(
            $site->getTheme()
        );

        $page = new PageBasic();

        $sitePage = new SitePage(
            $site,
            new Page();
        $layout
        )

        $renderData = $this->getLayoutRenderData();

        $renderData['[page]'] = $html;

        return $this->renderSitePage(
            $sitePage,
            $renderData
        );
    }
}
