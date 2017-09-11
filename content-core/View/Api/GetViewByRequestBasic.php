<?php

namespace Zrcms\ContentCore\View\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Exception\CmsResourceNotExistsException;
use Zrcms\Content\Exception\ContentVersionNotExistsException;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResourceBySitePath;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerVersion;
use Zrcms\ContentCore\Page\Exception\PageNotFoundException;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResource;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourceByHost;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteVersion;
use Zrcms\ContentCore\Site\Exception\SiteNotFoundException;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutVersion;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Exception\ThemeNotFoundException;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Model\PropertiesView;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\ContentCore\View\Model\ViewBasic;
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
     * @param FindSiteCmsResourceByHost                  $findSiteCmsResourceByHost
     * @param FindPageContainerCmsResourceBySitePath     $findPageContainerCmsResourceBySitePath
     * @param FindLayoutCmsResourceByThemeNameLayoutName $findLayoutCmsResourceByThemeNameLayoutName
     * @param GetLayoutName                              $getLayoutName
     * @param FindThemeComponent                         $findThemeComponent
     * @param GetViewLayoutTags                          $getViewLayoutTags
     * @param RenderView                                 $renderView
     * @param BuildView                                  $buildView
     */
    public function __construct(
        FindSiteCmsResourceByHost $findSiteCmsResourceByHost,
        FindPageContainerCmsResourceBySitePath $findPageContainerCmsResourceBySitePath,
        FindLayoutCmsResourceByThemeNameLayoutName $findLayoutCmsResourceByThemeNameLayoutName,
        GetLayoutName $getLayoutName,
        FindThemeComponent $findThemeComponent,
        GetViewLayoutTags $getViewLayoutTags,
        RenderView $renderView,
        BuildView $buildView
    ) {
        $this->findSiteCmsResourceByHost = $findSiteCmsResourceByHost;
        $this->findPageContainerCmsResourceBySitePath = $findPageContainerCmsResourceBySitePath;
        $this->findLayoutCmsResourceByThemeNameLayoutName = $findLayoutCmsResourceByThemeNameLayoutName;
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
            /** @var SiteCmsResource $siteCmsResource */
            $siteCmsResource = $this->findSiteCmsResourceByHost->__invoke(
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

        if (empty($siteCmsResource)) {
            throw new SiteNotFoundException(
                'Site not found for host: (' . $uri->getHost() . ')'
            );
        }

        $themeName = $siteCmsResource->getContentVersion()->getThemeName();

        $themeComponent = $this->findThemeComponent->__invoke(
            $themeName
        );

        if (empty($themeComponent)) {
            throw new ThemeNotFoundException(
                'Theme not found (' . $themeName . ')'
                . ' for host: (' . $siteCmsResource->getHost() . ')'
                . ' with site ID: (' . $siteCmsResource->getContentVersion()->getId() . ')'
            );
        }

        $path = $uri->getPath();

        try {
            /** @var PageContainerCmsResource $pageContainerCmsResource */
            $pageContainerCmsResource = $this->findPageContainerCmsResourceBySitePath->__invoke(
                $siteCmsResource->getId(),
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

        if (empty($pageContainerCmsResource)) {
            throw new PageNotFoundException(
                'Page not found for host: (' . $uri->getHost() . ')'
                . ' and page: (' . $path . ')'
            );
        }

        $siteVersion = $siteCmsResource->getContentVersion();
        $pageContainerVersion = $pageContainerCmsResource->getContentVersion();

        $layoutName = $this->getLayoutName->__invoke(
            $siteVersion,
            $pageContainerVersion
        );

        try {
            /** @var LayoutCmsResource $layoutCmsResource */
            $layoutCmsResource = $this->findLayoutCmsResourceByThemeNameLayoutName->__invoke(
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

        if (empty($layoutCmsResource)) {
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
            => $siteCmsResource,

            PropertiesView::PAGE_CONTAINER_CMS_RESOURCE
            => $pageContainerCmsResource,

            PropertiesView::LAYOUT_CMS_RESOURCE
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
