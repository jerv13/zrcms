<?php

namespace Zrcms\ContentCore\View\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Trackable;
use Zrcms\ContentCore\Page\Api\Repository\FindPageCmsResourceBySitePath;
use Zrcms\ContentCore\Page\Exception\PageNotFound;
use Zrcms\ContentCore\Page\Fields\FieldsPageVersion;
use Zrcms\ContentCore\Page\Model\PageCmsResourceBasic;
use Zrcms\ContentCore\Page\Model\PageVersionBasic;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourceByHost;
use Zrcms\ContentCore\Site\Exception\SiteNotFound;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Exception\LayoutNotFound;
use Zrcms\ContentCore\Theme\Exception\ThemeNotFound;
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
    const OPTION_TITLE = FieldsPageVersion::TITLE;
    const OPTION_DESCRIPTION = FieldsPageVersion::DESCRIPTION;
    const OPTION_KEYWORDS = FieldsPageVersion::KEYWORDS;
    const OPTION_HTML = FieldsPageVersion::PRE_RENDERED_HTML;
    const OPTION_LAYOUT = FieldsPageVersion::LAYOUT;
    const OPTION_RENDER_TAGS_GETTER = FieldsPageVersion::RENDER_TAGS_GETTER;
    const OPTION_CONTAINERS_DATA = FieldsPageVersion::CONTAINERS_DATA;

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
    protected $defaultTitle = '';

    /**
     * @var string
     */
    protected $defaultDescription = '';

    /**
     * @var string
     */
    protected $defaultKeywords = '';

    /**
     * @param FindSiteCmsResourceByHost                  $findSiteCmsResourceByHost
     * @param FindPageCmsResourceBySitePath              $findPageCmsResourceBySitePath
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
        FindPageCmsResourceBySitePath $findPageCmsResourceBySitePath,
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
        $this->findPageCmsResourceBySitePath = $findPageCmsResourceBySitePath;
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
     * @throws LayoutNotFound
     * @throws PageNotFound
     * @throws SiteNotFound
     * @throws ThemeNotFound
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
            throw new SiteNotFound(
                'Site not found for host: (' . $uri->getHost() . ')'
            );
        }

        $siteVersion = $siteCmsResource->getContentVersion();

        $themeName = $siteCmsResource->getContentVersion()->getThemeName();

        $themeComponent = $this->findThemeComponent->__invoke(
            $themeName
        );

        if (empty($themeComponent)) {
            throw new ThemeNotFound(
                'Theme not found (' . $themeName . ')'
                . ' for host: (' . $siteCmsResource->getHost() . ')'
                . ' with site ID: (' . (string)$siteCmsResource->getContentVersionId() . ')'
            );
        }

        $html = Param::getString($options, self::OPTION_HTML, null);

        if ($html === null) {
            throw new PageNotFound(
                'Page not found for host: (' . $uri->getHost() . ')'
                . ' with empty html page'
            );
        }

        $pageVersion = new PageVersionBasic(
            $uri->getPath(),
            [
                FieldsPageVersion::TITLE
                => Param::getString($options, self::OPTION_TITLE, $this->defaultTitle),

                FieldsPageVersion::DESCRIPTION
                => Param::getString($options, self::OPTION_DESCRIPTION, $this->defaultDescription),

                FieldsPageVersion::KEYWORDS
                => Param::getString($options, self::OPTION_KEYWORDS, $this->defaultKeywords),

                FieldsPageVersion::LAYOUT
                => Param::getString($options, self::OPTION_LAYOUT, null),

                FieldsPageVersion::PRE_RENDERED_HTML
                => Param::getString($options, self::OPTION_HTML, ''),

                // DEFAULT: 'html' AKA GetPageRenderTagsHtml
                FieldsPageVersion::RENDER_TAGS_GETTER
                => Param::getString($options, self::OPTION_RENDER_TAGS_GETTER, 'html'),

                FieldsPageVersion::CONTAINERS_DATA
                => Param::getArray($options, self::OPTION_CONTAINERS_DATA, []),
                FieldsPageVersion::PATH => $uri->getPath(),
                FieldsPageVersion::SITE_CMS_RESOURCE_ID => $siteCmsResource->getId(),
            ],
            Trackable::UNKNOWN_USER_ID,
            'Render HTML: ' . get_class($this)
        );

        $pageCmsResource = new PageCmsResourceBasic(
            $uri->getPath(),
            true,
            $pageVersion,
            Trackable::UNKNOWN_USER_ID,
            'Render HTML: ' . get_class($this)
        );

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
