<?php

namespace Zrcms\ContentCore\View\Api\Repository;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Exception\CmsResourceNotExistsException;
use Zrcms\Content\Exception\ContentVersionNotExistsException;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResourceVersionBySitePath;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerVersion;
use Zrcms\ContentCore\Page\Exception\PageNotFoundException;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResourceVersion;
use Zrcms\ContentCore\PreparePagePath;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourceVersionByHost;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteVersion;
use Zrcms\ContentCore\Site\Exception\SiteNotFoundException;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceVersion;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResourceVersionByThemeNameLayoutName;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutVersion;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Exception\ThemeNotFoundException;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResourceVersion;
use Zrcms\ContentCore\View\Api\BuildView;
use Zrcms\ContentCore\View\Api\GetLayoutName;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
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
     * @var FindSiteCmsResourceVersionByHost
     */
    protected $findSiteCmsResourceVersionByHost;

    /**
     * @var FindSiteVersion
     */
    protected $findSiteVersion;

    /**
     * @var FindPageContainerCmsResourceVersionBySitePath
     */
    protected $findPageContainerCmsResourceVersionBySitePath;

    /**
     * @var FindPageContainerVersion
     */
    protected $findPageContainerVersion;

    /**
     * @var FindLayoutCmsResourceVersionByThemeNameLayoutName
     */
    protected $findLayoutCmsResourceVersionByThemeNameLayoutName;

    /**
     * @var FindLayoutVersion
     */
    protected $findLayoutVersion;

    /**
     * @var GetLayoutName
     */
    protected $getLayoutName;

    /**
     * @var FindThemeComponent
     */
    protected $findThemeComponent;

    /**
     * @var GetViewLayoutTags
     */
    protected $getViewLayoutTags;

    /**
     * @var RenderView
     */
    protected $renderView;

    /**
     * @var BuildView
     */
    protected $buildView;

    /**
     * @param FindSiteCmsResourceVersionByHost                  $findSiteCmsResourceVersionByHost
     * @param FindPageContainerCmsResourceVersionBySitePath     $findPageContainerCmsResourceVersionBySitePath
     * @param FindLayoutCmsResourceVersionByThemeNameLayoutName $findLayoutCmsResourceVersionByThemeNameLayoutName
     * @param GetLayoutName                                     $getLayoutName
     * @param FindThemeComponent                                $findThemeComponent
     * @param GetViewLayoutTags                                 $getViewLayoutTags
     * @param RenderView                                        $renderView
     * @param BuildView                                         $buildView
     */
    public function __construct(
        FindSiteCmsResourceVersionByHost $findSiteCmsResourceVersionByHost,
        FindPageContainerCmsResourceVersionBySitePath $findPageContainerCmsResourceVersionBySitePath,
        FindLayoutCmsResourceVersionByThemeNameLayoutName $findLayoutCmsResourceVersionByThemeNameLayoutName,
        GetLayoutName $getLayoutName,
        FindThemeComponent $findThemeComponent,
        GetViewLayoutTags $getViewLayoutTags,
        RenderView $renderView,
        BuildView $buildView
    ) {
        $this->findSiteCmsResourceVersionByHost = $findSiteCmsResourceVersionByHost;
        $this->findPageContainerCmsResourceVersionBySitePath = $findPageContainerCmsResourceVersionBySitePath;
        $this->findLayoutCmsResourceVersionByThemeNameLayoutName = $findLayoutCmsResourceVersionByThemeNameLayoutName;
        $this->getLayoutName = $getLayoutName;

        $this->findThemeComponent = $findThemeComponent;
        $this->getViewLayoutTags = $getViewLayoutTags;
        $this->renderView = $renderView;
        $this->buildView = $buildView;
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

        try {
            /** @var SiteCmsResourceVersion $siteCmsResourceVersion */
            $siteCmsResourceVersion = $this->findSiteCmsResourceVersionByHost->__invoke(
                $uri->getHost()
            );
        } catch (CmsResourceNotExistsException $exception) {
            throw new SiteNotFoundException(
                'Site resource not exists for host: (' . $uri->getHost() . ')',
                0,
                $exception
            );
        } catch (ContentVersionNotExistsException $exception) {
            throw new SiteNotFoundException(
                'Site version not exists for host: (' . $uri->getHost() . ')',
                0,
                $exception
            );
        }

        if (empty($siteCmsResourceVersion)) {
            throw new SiteNotFoundException(
                'Site not found for host: (' . $uri->getHost() . ')'
            );
        }

        $themeName = $siteCmsResourceVersion->getVersion()->getThemeName();

        $themeComponent = $this->findThemeComponent->__invoke(
            $themeName
        );

        if (empty($themeComponent)) {
            throw new ThemeNotFoundException(
                'Theme not found (' . $themeName . ')'
                . ' for host: (' . $siteCmsResourceVersion->getCmsResource()->getHost() . ')'
                . ' with site ID: (' . $siteCmsResourceVersion->getCmsResourceId() . ')'
            );
        }

        $path = PreparePagePath::clean($uri->getPath());

        try {
            /** @var PageContainerCmsResourceVersion $pageContainerCmsResourceVersion */
            $pageContainerCmsResourceVersion = $this->findPageContainerCmsResourceVersionBySitePath->__invoke(
                $siteCmsResourceVersion->getCmsResourceId(),
                $path
            );

        } catch (CmsResourceNotExistsException $exception) {
            throw new SiteNotFoundException(
                'Page resource not exists for host: (' . $uri->getHost() . ')'
                . ' and page: (' . $path . ')',
                0,
                $exception
            );
        } catch (ContentVersionNotExistsException $exception) {
            throw new SiteNotFoundException(
                'Page version not exists for host: (' . $uri->getHost() . ')'
                . ' and page: (' . $path . ')',
                0,
                $exception
            );
        }

        if (empty($pageContainerCmsResourceVersion)) {
            throw new PageNotFoundException(
                'Page not found for host: (' . $uri->getHost() . ')'
                . ' and page: (' . $path . ')'
            );
        }

        $siteVersion = $siteCmsResourceVersion->getVersion();
        $pageContainerVersion = $pageContainerCmsResourceVersion->getVersion();

        $layoutName = $this->getLayoutName->__invoke(
            $siteVersion,
            $pageContainerVersion
        );

        try {
            /** @var LayoutCmsResourceVersion $layoutCmsResourceVersion */
            $layoutCmsResourceVersion = $this->findLayoutCmsResourceVersionByThemeNameLayoutName->__invoke(
                $themeName,
                $layoutName
            );
        } catch (CmsResourceNotExistsException $exception) {
            throw new SiteNotFoundException(
                'Layout resource not exists: (' . $layoutName . ')'
                . ' with theme name: (' . $themeName . ')'
                . ' for site version ID: (' . $siteVersion->getId() . ')'
                . ' and page version ID: (' . $pageContainerVersion->getId() . ')',
                0,
                $exception
            );
        } catch (ContentVersionNotExistsException $exception) {
            throw new SiteNotFoundException(
                'Layout version not exists: (' . $layoutName . ')'
                . ' with theme name: (' . $themeName . ')'
                . ' for site version ID: (' . $siteVersion->getId() . ')'
                . ' and page version ID: (' . $pageContainerVersion->getId() . ')',
                0,
                $exception
            );
        }

        if (empty($layoutCmsResourceVersion)) {
            throw new PageNotFoundException(
                'Layout not found: (' . $layoutName . ')'
                . ' with theme name: (' . $themeName . ')'
                . ' for site version ID: (' . $siteVersion->getId() . ')'
                . ' and page version ID: (' . $pageContainerVersion->getId() . ')'
            );
        }

        $properties = [
            PropertiesView::ID
            => 'basic',

            PropertiesView::SITE_CMS_RESOURCE
            => $siteCmsResourceVersion->getCmsResource(),

            PropertiesView::SITE
            => $siteVersion,

            PropertiesView::PAGE_CONTAINER_CMS_RESOURCE
            => $pageContainerCmsResourceVersion->getCmsResource(),

            PropertiesView::PAGE
            => $pageContainerVersion,

            PropertiesView::LAYOUT_CMS_RESOURCE
            => $layoutCmsResourceVersion->getCmsResource(),

            PropertiesView::LAYOUT
            => $layoutCmsResourceVersion->getVersion(),
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
