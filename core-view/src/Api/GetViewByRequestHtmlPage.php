<?php

namespace Zrcms\CoreView\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Model\Trackable;
use Zrcms\CorePage\Fields\FieldsPageVersion;
use Zrcms\CorePage\Model\PageCmsResource;
use Zrcms\CorePage\Model\PageCmsResourceBasic;
use Zrcms\CorePage\Model\PageVersion;
use Zrcms\CorePage\Model\PageVersionBasic;
use Zrcms\CoreView\Api\Render\GetViewLayoutTags;
use Zrcms\CoreView\Exception\LayoutNotFound;
use Zrcms\CoreView\Exception\PageNotFound;
use Zrcms\CoreView\Exception\SiteNotFound;
use Zrcms\CoreView\Exception\ThemeNotFound;
use Zrcms\CoreView\Fields\FieldsView;
use Zrcms\CoreView\Model\View;
use Zrcms\CoreView\Model\ViewBasic;
use Reliv\ArrayProperties\Property;

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

    protected $getSiteCmsResource;
    protected $getThemeName;
    protected $getLayoutName;
    protected $getLayoutCmsResource;
    protected $getViewLayoutTags;
    protected $buildView;

    protected $defaultTitle = '';
    protected $defaultDescription = '';
    protected $defaultKeywords = '';

    /**
     * @param GetSiteCmsResource   $getSiteCmsResource
     * @param GetThemeName         $getThemeName
     * @param GetLayoutName        $getLayoutName
     * @param GetLayoutCmsResource $getLayoutCmsResource
     * @param GetViewLayoutTags    $getViewLayoutTags
     * @param BuildView            $buildView
     * @param string               $defaultTitle
     * @param string               $defaultDescription
     * @param string               $defaultKeywords
     */
    public function __construct(
        GetSiteCmsResource $getSiteCmsResource,
        GetThemeName $getThemeName,
        GetLayoutName $getLayoutName,
        GetLayoutCmsResource $getLayoutCmsResource,
        GetViewLayoutTags $getViewLayoutTags,
        BuildView $buildView,
        string $defaultTitle = '',
        string $defaultDescription = '',
        string $defaultKeywords = ''
    ) {
        $this->getSiteCmsResource = $getSiteCmsResource;
        $this->getThemeName = $getThemeName;
        $this->getLayoutName = $getLayoutName;
        $this->getLayoutCmsResource = $getLayoutCmsResource;
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

        $siteCmsResource = $this->getSiteCmsResource->__invoke(
            $uri->getHost()
        );

        $themeName = $this->getThemeName->__invoke(
            $siteCmsResource
        );

        $pageCmsResource = $this->getPageCmsResource(
            $siteCmsResource->getId(),
            $uri->getPath(),
            $options
        );

        $siteVersion = $siteCmsResource->getContentVersion();
        $pageVersion = $pageCmsResource->getContentVersion();

        $layoutName = $this->getLayoutName->__invoke(
            $siteVersion,
            $pageVersion
        );

        $layoutCmsResource = $this->getLayoutCmsResource->__invoke(
            $themeName,
            $layoutName
        );

        $html = Property::getString($options, self::OPTION_HTML, null);

        if ($html === null) {
            throw new PageNotFound(
                'Page not found for host: (' . $uri->getHost() . ')'
                . ' with empty html page'
            );
        }

        $properties = [
            FieldsView::SITE_CMS_RESOURCE
            => $siteCmsResource,

            FieldsView::PAGE_CMS_RESOURCE
            => $pageCmsResource,

            FieldsView::LAYOUT_CMS_RESOURCE
            => $layoutCmsResource,
        ];

        $additionalProperties = Property::get(
            $options,
            self::OPTION_ADDITIONAL_PROPERTIES,
            []
        );

        $properties = array_merge(
            $additionalProperties,
            $properties
        );

        $view = new ViewBasic(
            $properties,
            $siteCmsResource->getHost() . $pageCmsResource->getPath()
        );

        return $this->buildView->__invoke(
            $request,
            $view
        );
    }

    /**
     * @param string $siteCmsResourceId
     * @param string $path
     * @param array  $options
     *
     * @return PageVersion
     */
    protected function getPageVersion(
        string $siteCmsResourceId,
        string $path,
        array $options = []
    ): PageVersion {
        return new PageVersionBasic(
            $path,
            [
                FieldsPageVersion::TITLE
                => Property::getString($options, self::OPTION_TITLE, $this->defaultTitle),

                FieldsPageVersion::DESCRIPTION
                => Property::getString($options, self::OPTION_DESCRIPTION, $this->defaultDescription),

                FieldsPageVersion::KEYWORDS
                => Property::getString($options, self::OPTION_KEYWORDS, $this->defaultKeywords),

                FieldsPageVersion::LAYOUT
                => Property::getString($options, self::OPTION_LAYOUT, null),

                FieldsPageVersion::PRE_RENDERED_HTML
                => Property::getString($options, self::OPTION_HTML, ''),

                // DEFAULT: 'html' AKA GetPageRenderTagsHtml
                FieldsPageVersion::RENDER_TAGS_GETTER
                => Property::getString($options, self::OPTION_RENDER_TAGS_GETTER, 'html'),

                FieldsPageVersion::CONTAINERS_DATA
                => Property::getArray($options, self::OPTION_CONTAINERS_DATA, []),
                FieldsPageVersion::PATH => $path,
                FieldsPageVersion::SITE_CMS_RESOURCE_ID => $siteCmsResourceId,
            ],
            Trackable::UNKNOWN_USER_ID,
            'Render HTML: ' . get_class($this)
        );
    }

    /**
     * @param string $siteCmsResourceId
     * @param string $path
     * @param array  $options
     *
     * @return PageCmsResource
     */
    protected function getPageCmsResource(
        string $siteCmsResourceId,
        string $path,
        array $options = []
    ): PageCmsResource {
        $pageVersion = $this->getPageVersion(
            $siteCmsResourceId,
            $path,
            $options
        );

        return new PageCmsResourceBasic(
            $pageVersion->getPath(),
            true,
            $pageVersion,
            Trackable::UNKNOWN_USER_ID,
            'Render HTML: ' . get_class($this)
        );
    }
}
