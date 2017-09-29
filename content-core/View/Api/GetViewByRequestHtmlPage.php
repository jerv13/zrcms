<?php

namespace Zrcms\ContentCore\View\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Trackable;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResourceBySitePath;
use Zrcms\ContentCore\Page\Exception\PageNotFoundException;
use Zrcms\ContentCore\Page\Fields\FieldsPageContainerCmsResource;
use Zrcms\ContentCore\Page\Fields\FieldsPageContainerVersion;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResourceBasic;
use Zrcms\ContentCore\Page\Model\PageContainerVersionBasic;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourceByHost;
use Zrcms\ContentCore\Site\Exception\SiteNotFoundException;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Exception\LayoutNotFoundException;
use Zrcms\ContentCore\Theme\Exception\ThemeNotFoundException;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Fields\FieldsView;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\ContentCore\View\Model\ViewBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewByRequestHtmlPage implements GetViewByRequest
{
    const OPTION_TITLE = FieldsPageContainerVersion::TITLE;
    const OPTION_DESCRIPTION = FieldsPageContainerVersion::DESCRIPTION;
    const OPTION_KEYWORDS = FieldsPageContainerVersion::KEYWORDS;
    const OPTION_HTML = FieldsPageContainerVersion::PRE_RENDERED_HTML;
    const OPTION_LAYOUT = FieldsPageContainerVersion::LAYOUT;
    const OPTION_RENDER_TAGS_GETTER = FieldsPageContainerVersion::RENDER_TAGS_GETTER;
    const OPTION_RENDERER = FieldsPageContainerVersion::RENDERER;
    const OPTION_BLOCK_VERSIONS = FieldsPageContainerVersion::BLOCK_VERSIONS;

    /**
     * @var FindSiteCmsResourceByHost
     */
    protected $findSiteCmsResourceByHost;

    /**
     * @var FindPageContainerCmsResourceBySitePath
     */
    protected $findPageContainerCmsResourceBySitePath;

    /**
     * @var FindLayoutCmsResourceByThemeNameLayoutName
     */
    protected $findLayoutCmsResourceByThemeNameLayoutName;

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
     * @var BuildView
     */
    protected $buildView;

    /**
     * @var string
     */
    protected  $defaultTitle = '';

    /**
     * @var string
     */
    protected  $defaultDescription = '';

    /**
     * @var string
     */
    protected  $defaultKeywords = '';

    /**
     * @param FindSiteCmsResourceByHost                  $findSiteCmsResourceByHost
     * @param FindPageContainerCmsResourceBySitePath     $findPageContainerCmsResourceBySitePath
     * @param FindLayoutCmsResourceByThemeNameLayoutName $findLayoutCmsResourceByThemeNameLayoutName
     * @param GetLayoutName                              $getLayoutName
     * @param FindThemeComponent                         $findThemeComponent
     * @param GetViewLayoutTags                          $getViewLayoutTags
     * @param BuildView                                  $buildView
     * @param string                                     $defaultTitle
     * @param string                                     $defaultDescription
     * @param string                                     $defaultKeywords
     */
    public function __construct(
        FindSiteCmsResourceByHost $findSiteCmsResourceByHost,
        FindPageContainerCmsResourceBySitePath $findPageContainerCmsResourceBySitePath,
        FindLayoutCmsResourceByThemeNameLayoutName $findLayoutCmsResourceByThemeNameLayoutName,
        GetLayoutName $getLayoutName,
        FindThemeComponent $findThemeComponent,
        GetViewLayoutTags $getViewLayoutTags,
        BuildView $buildView,
        string $defaultTitle = '',
        string $defaultDescription = '',
        string $defaultKeywords = ''
    ) {
        $this->findSiteCmsResourceByHost = $findSiteCmsResourceByHost;
        $this->findPageContainerCmsResourceBySitePath = $findPageContainerCmsResourceBySitePath;
        $this->findLayoutCmsResourceByThemeNameLayoutName = $findLayoutCmsResourceByThemeNameLayoutName;
        $this->getLayoutName = $getLayoutName;

        $this->findThemeComponent = $findThemeComponent;
        $this->getViewLayoutTags = $getViewLayoutTags;
        $this->buildView = $buildView;
        $this->defaultTitle = $defaultTitle;
        $this->defaultDescription = $defaultDescription;
        $this->defaultKeywords = $defaultKeywords;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return View
     * @throws LayoutNotFoundException
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

        /** @var SiteCmsResource $siteCmsResource */
        $siteCmsResource = $this->findSiteCmsResourceByHost->__invoke(
            $uri->getHost()
        );

        if (empty($siteCmsResource)) {
            throw new SiteNotFoundException(
                'Site not found for host: (' . $uri->getHost() . ')'
            );
        }

        $siteVersion = $siteCmsResource->getContentVersion();

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

        $html = Param::getString($options, self::OPTION_HTML, null);

        if ($html === null) {
            throw new PageNotFoundException(
                'Page not found for host: (' . $uri->getHost() . ')'
                . ' with empty html page'
            );
        }

        $pageContainerVersion = new PageContainerVersionBasic(
            $uri->getPath(),
            [
                FieldsPageContainerVersion::TITLE
                => Param::getString($options, self::OPTION_TITLE, $this->defaultTitle),

                FieldsPageContainerVersion::DESCRIPTION
                => Param::getString($options, self::OPTION_DESCRIPTION, $this->defaultDescription),

                FieldsPageContainerVersion::KEYWORDS
                => Param::getString($options, self::OPTION_KEYWORDS, $this->defaultKeywords),

                FieldsPageContainerVersion::LAYOUT
                => Param::getString($options, self::OPTION_LAYOUT, null),

                FieldsPageContainerVersion::PRE_RENDERED_HTML
                => Param::getString($options, self::OPTION_HTML, ''),

                // DEFAULT: 'html' AKA GetPageContainerRenderTagsHtml
                FieldsPageContainerVersion::RENDER_TAGS_GETTER
                => Param::getString($options, self::OPTION_RENDER_TAGS_GETTER, 'html'),

                FieldsPageContainerVersion::RENDERER
                => Param::getString($options, self::OPTION_RENDERER, ''),

                FieldsPageContainerVersion::BLOCK_VERSIONS
                => Param::getArray($options, self::OPTION_BLOCK_VERSIONS, []),
            ],
            Trackable::UNKNOWN_USER_ID,
            'Render HTML: ' . get_class($this)
        );

        $pageContainerCmsResource = new PageContainerCmsResourceBasic(
            $uri->getPath(),
            true,
            $pageContainerVersion,
            [
                FieldsPageContainerCmsResource::PATH => $uri->getPath(),
                FieldsPageContainerCmsResource::SITE_CMS_RESOURCE_ID => $siteCmsResource->getId(),
            ],
            Trackable::UNKNOWN_USER_ID,
            'Render HTML: ' . get_class($this)
        );

        $layoutName = $this->getLayoutName->__invoke(
            $siteVersion,
            $pageContainerVersion
        );

        /** @var LayoutCmsResource $layoutCmsResource */
        $layoutCmsResource = $this->findLayoutCmsResourceByThemeNameLayoutName->__invoke(
            $themeName,
            $layoutName
        );

        if (empty($layoutCmsResource)) {
            throw new LayoutNotFoundException(
                'Layout not found: (' . $layoutName . ')'
                . ' with theme name: (' . $themeName . ')'
                . ' for site version ID: (' . $siteVersion->getId() . ')'
                . ' and page version ID: (' . $pageContainerVersion->getId() . ')'
            );
        }

        $properties = [
            FieldsView::SITE_CMS_RESOURCE
            => $siteCmsResource,

            FieldsView::PAGE_CONTAINER_CMS_RESOURCE
            => $pageContainerCmsResource,

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