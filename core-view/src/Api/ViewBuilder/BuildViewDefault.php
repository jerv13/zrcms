<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\CoreView\Api\GetLayoutCmsResource;
use Zrcms\CoreView\Api\GetLayoutName;
use Zrcms\CoreView\Api\GetPageCmsResource;
use Zrcms\CoreView\Api\GetSiteCmsResource;
use Zrcms\CoreView\Api\GetSiteContainerCmsResources;
use Zrcms\CoreView\Api\GetThemeName;
use Zrcms\CoreView\Exception\ViewDataNotFound;
use Zrcms\CoreView\Model\View;
use Zrcms\CoreView\Model\ViewBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildViewDefault implements BuildView
{
    protected $published = true; // AKA only published

    protected $getSiteCmsResource;
    protected $getThemeName;
    protected $getPageCmsResource;
    protected $getLayoutName;
    protected $getLayoutCmsResource;
    protected $getSiteContainerCmsResources;

    /**
     * @param GetSiteCmsResource           $getSiteCmsResource
     * @param GetThemeName                 $getThemeName
     * @param GetPageCmsResource           $getPageCmsResource
     * @param GetLayoutName                $getLayoutName
     * @param GetLayoutCmsResource         $getLayoutCmsResource
     * @param GetSiteContainerCmsResources $getSiteContainerCmsResources
     */
    public function __construct(
        GetSiteCmsResource $getSiteCmsResource,
        GetThemeName $getThemeName,
        GetPageCmsResource $getPageCmsResource,
        GetLayoutName $getLayoutName,
        GetLayoutCmsResource $getLayoutCmsResource,
        GetSiteContainerCmsResources $getSiteContainerCmsResources
    ) {
        $this->getSiteCmsResource = $getSiteCmsResource;
        $this->getThemeName = $getThemeName;
        $this->getPageCmsResource = $getPageCmsResource;
        $this->getLayoutName = $getLayoutName;
        $this->getLayoutCmsResource = $getLayoutCmsResource;
        $this->getSiteContainerCmsResources = $getSiteContainerCmsResources;
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
            $uri->getHost(),
            $this->published
        );

        $themeName = $this->getThemeName->__invoke(
            $siteCmsResource
        );

        $pageCmsResource = $this->getPageCmsResource->__invoke(
            $siteCmsResource->getId(),
            $uri->getPath(),
            $this->published
        );

        $siteVersion = $siteCmsResource->getContentVersion();
        $pageVersion = $pageCmsResource->getContentVersion();

        $layoutName = $this->getLayoutName->__invoke(
            $siteVersion,
            $pageVersion
        );

        $layoutCmsResource = $this->getLayoutCmsResource->__invoke(
            $themeName,
            $layoutName,
            $this->published
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
}
