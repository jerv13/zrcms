<?php

namespace Zrcms\Core\Page\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Container\Api\BuildContainerUri;
use Zrcms\Core\Container\Api\BuildLayoutUri;
use Zrcms\Core\ThemeLayout\Api\Repository\FindLayoutCmsResource;
use Zrcms\Core\Page\Api\BuildPageUri;
use Zrcms\Core\Page\Api\FindPagePublished;
use Zrcms\Core\Page\Api\Repository\FindPageCmsResource;
use Zrcms\Core\Page\Model\PageBasic;
use Zrcms\Core\Page\Model\PageProperties;
use Zrcms\Core\PageView\Api\Render\RenderPageView;
use Zrcms\Core\PageView\Model\PageViewBasic;
use Zrcms\Core\PageView\Model\PageViewProperties;
use Zrcms\Core\Site\Api\FindSitePublished;
use Zrcms\Core\Site\Api\Repository\FindSiteCmsResource;
use Zrcms\Core\Site\Model\Site;
use Zrcms\Core\Site\Model\SiteProperties;
use Zrcms\Core\Theme\Api\FindTheme;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PageController
{
    protected $buildCmsUri;

    public function __construct(
        FindSiteCmsResource $findSiteCmsResource,
        FindTheme $findTheme,
        FindPageCmsResource $findPageCmsResource,
        FindLayoutCmsResource $findLayoutCmsResource,
        BuildPageUri $buildPageUri,
        BuildContainerUri $buildContainerUri,
        BuildLayoutUri $buildLayoutUri,
        RenderPageView $renderPageView
    ) {
        $this->findSiteCmsResource = $findSiteCmsResource;
        $this->findTheme = $findTheme;
        $this->findPageCmsResource = $findPageCmsResource;
        $this->findLayoutCmsResource = $findLayoutCmsResource;
        $this->buildPageUri = $buildPageUri;
        $this->buildContainerUri = $buildContainerUri;
        $this->buildLayoutUri = $buildLayoutUri
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
            return $response->withStatus(404);
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
            return $response->withStatus(404);
        }

        $page = $pageCmsResource->getContent();

        $theme = $this->findTheme->__invoke(
            $site->getTheme()
        );

        if (empty($theme)) {
            // @todo throw
            return $response->withStatus(404);
        }

        $layoutName = $page->getProperty(
            PageProperties::LAYOUT,
            $site->getProperty(
                SiteProperties::LAYOUT
            )
        );

        $this->buildLayoutUri->__invoke(
            $site->getId(),
            $layoutName
        );

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
