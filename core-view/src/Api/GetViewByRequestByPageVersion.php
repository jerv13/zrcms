<?php

namespace Zrcms\CoreView\Api;

use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\CoreView\Exception\LayoutNotFound;
use Zrcms\CoreView\Exception\PageNotFound;
use Zrcms\CoreView\Exception\SiteNotFound;
use Zrcms\CoreView\Exception\ThemeNotFound;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewByRequestByPageVersion implements GetViewByRequest
{
    const OPTION_PAGE_VERSION_ID = 'page-version-id';

    protected $getViewByRequestBasic;

    /**
     * @param GetViewByRequestBasic $getViewByRequestBasic
     */
    public function __construct(
        GetViewByRequestBasic $getViewByRequestBasic
    ) {
        $this->getViewByRequestBasic = $getViewByRequestBasic;
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
        $pageVersionId = Property::get(
            $options,
            self::OPTION_PAGE_VERSION_ID,
            null
        );

        if ($pageVersionId === null) {
            return $this->getViewByRequestBasic->__invoke($request, $options);
        }

        $uri = $request->getUri();

        $publishedOnly = Property::get(
            $options,
            GetViewByRequestBasic::OPTION_PUBLISHED_ONLY,
            GetViewByRequestBasic::DEFAULT_PUBLISHED_ONLY
        );

        $published = true;

        if ($publishedOnly !== true) {
            $published = null;
        }

        $siteCmsResource = $this->getSiteCmsResource->__invoke(
            $uri->getHost(),
            $published
        );

        $themeName = $this->getThemeName->__invoke(
            $siteCmsResource
        );

        $pageCmsResource = $this->getPageCmsResource->__invoke(
            $siteCmsResource->getId(),
            $uri->getPath(),
            $published
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
            $published
        );

        return $this->buildView(
            $request,
            $siteCmsResource,
            $pageCmsResource,
            $layoutCmsResource,
            $options
        );
    }
}
