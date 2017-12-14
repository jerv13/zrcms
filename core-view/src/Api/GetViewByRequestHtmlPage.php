<?php

namespace Zrcms\CoreView\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Model\Trackable;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourceBySitePath;
use Zrcms\CorePage\Exception\PageNotFound;
use Zrcms\CorePage\Fields\FieldsPageVersion;
use Zrcms\CorePage\Model\PageCmsResourceBasic;
use Zrcms\CorePage\Model\PageVersionBasic;
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
     * @param FindComponent                         $findComponent
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
        FindComponent $findComponent,
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

        $this->findComponent = $findComponent;
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

        $siteVersion = $siteCmsResource->getContentVersion();

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
