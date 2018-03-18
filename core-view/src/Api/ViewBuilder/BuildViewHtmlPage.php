<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\Core\Model\Trackable;
use Zrcms\CorePage\Fields\FieldsPageVersion;
use Zrcms\CorePage\Model\PageCmsResource;
use Zrcms\CorePage\Model\PageCmsResourceBasic;
use Zrcms\CorePage\Model\PageVersion;
use Zrcms\CorePage\Model\PageVersionBasic;
use Zrcms\CoreView\Api\GetLayoutCmsResource;
use Zrcms\CoreView\Api\GetLayoutName;
use Zrcms\CoreView\Api\GetSiteCmsResource;
use Zrcms\CoreView\Api\GetSiteContainerCmsResources;
use Zrcms\CoreView\Api\GetThemeName;
use Zrcms\CoreView\Exception\ViewDataNotFound;
use Zrcms\CoreView\Model\View;
use Zrcms\CoreView\Model\ViewBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildViewHtmlPage implements BuildView
{
    const ATTRIBUTE_VIEW_HTML = 'zrcms-view-html';

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
    protected $getSiteContainerCmsResources;
    protected $buildView;

    protected $defaultTitle = '';
    protected $defaultDescription = '';
    protected $defaultKeywords = '';

    /**
     * @param GetSiteCmsResource           $getSiteCmsResource
     * @param GetThemeName                 $getThemeName
     * @param GetLayoutName                $getLayoutName
     * @param GetLayoutCmsResource         $getLayoutCmsResource
     * @param GetSiteContainerCmsResources $getSiteContainerCmsResources
     * @param string                       $defaultTitle
     * @param string                       $defaultDescription
     * @param string                       $defaultKeywords
     */
    public function __construct(
        GetSiteCmsResource $getSiteCmsResource,
        GetThemeName $getThemeName,
        GetLayoutName $getLayoutName,
        GetLayoutCmsResource $getLayoutCmsResource,
        GetSiteContainerCmsResources $getSiteContainerCmsResources,
        string $defaultTitle = '',
        string $defaultDescription = '',
        string $defaultKeywords = ''
    ) {
        $this->getSiteCmsResource = $getSiteCmsResource;
        $this->getThemeName = $getThemeName;
        $this->getLayoutName = $getLayoutName;
        $this->getLayoutCmsResource = $getLayoutCmsResource;
        $this->getSiteContainerCmsResources = $getSiteContainerCmsResources;

        $this->defaultTitle = $defaultTitle;
        $this->defaultDescription = $defaultDescription;
        $this->defaultKeywords = $defaultKeywords;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return View
     * @throws ViewDataNotFound
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

        // Get form options or attribute
        $options[self::OPTION_HTML] = Property::getString(
            $options,
            self::OPTION_HTML,
            $request->getAttribute(self::ATTRIBUTE_VIEW_HTML, '')
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

        $siteContainerCmsResources = $this->getSiteContainerCmsResources->__invoke(
            $siteCmsResource->getId(),
            [GetSiteContainerCmsResources::OPTION_LAYOUT_VERSION => $layoutCmsResource->getContentVersion()]
        );

        return ViewBasic::build(
            $siteCmsResource,
            $pageCmsResource,
            $layoutCmsResource,
            $siteContainerCmsResources,
            Property::getString(
                $options,
                self::OPTION_VIEW_STRATEGY
            ),
            Property::getArray(
                $options,
                self::OPTION_VIEW_PROPERTIES,
                []
            ),
            Property::getString(
                $options,
                self::OPTION_VIEW_ID,
                null
            )
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
                FieldsPageVersion::TITLE => Property::getString(
                    $options,
                    self::OPTION_TITLE,
                    $this->defaultTitle
                ),

                FieldsPageVersion::DESCRIPTION => Property::getString(
                    $options,
                    self::OPTION_DESCRIPTION,
                    $this->defaultDescription
                ),

                FieldsPageVersion::KEYWORDS => Property::getString(
                    $options,
                    self::OPTION_KEYWORDS,
                    $this->defaultKeywords
                ),

                FieldsPageVersion::LAYOUT => Property::getString(
                    $options,
                    self::OPTION_LAYOUT,
                    null
                ),

                FieldsPageVersion::PRE_RENDERED_HTML => Property::getString(
                    $options,
                    self::OPTION_HTML,
                    ''
                ),

                // DEFAULT: 'html' AKA GetPageRenderTagsHtml
                FieldsPageVersion::RENDER_TAGS_GETTER => Property::getString(
                    $options,
                    self::OPTION_RENDER_TAGS_GETTER,
                    'html'
                ),

                FieldsPageVersion::CONTAINERS_DATA => Property::getArray(
                    $options,
                    self::OPTION_CONTAINERS_DATA,
                    []
                ),
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
