<?php

namespace Zrcms\CoreView\Api;

use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\CoreView\Exception\InvalidGetViewByRequest;
use Zrcms\CoreView\Exception\LayoutNotFound;
use Zrcms\CoreView\Exception\PageNotFound;
use Zrcms\CoreView\Exception\SiteNotFound;
use Zrcms\CoreView\Exception\ThemeNotFound;
use Zrcms\CoreView\Exception\ViewDataNotFound;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewByRequestBasic implements GetViewByRequest
{
    const OPTION_PUBLISHED_ONLY = 'published-only';

    const DEFAULT_PUBLISHED_ONLY = true;

    protected $getSiteCmsResource;
    protected $getThemeName;
    protected $getPageCmsResource;
    protected $getLayoutName;
    protected $getLayoutCmsResource;
    protected $buildView;

    /**
     * @param GetSiteCmsResource   $getSiteCmsResource
     * @param GetThemeName         $getThemeName
     * @param GetPageCmsResource   $getPageCmsResource
     * @param GetLayoutName        $getLayoutName
     * @param GetLayoutCmsResource $getLayoutCmsResource
     * @param BuildView            $buildView
     */
    public function __construct(
        GetSiteCmsResource $getSiteCmsResource,
        GetThemeName $getThemeName,
        GetPageCmsResource $getPageCmsResource,
        GetLayoutName $getLayoutName,
        GetLayoutCmsResource $getLayoutCmsResource,
        BuildView $buildView
    ) {
        $this->getSiteCmsResource = $getSiteCmsResource;
        $this->getThemeName = $getThemeName;
        $this->getPageCmsResource = $getPageCmsResource;
        $this->getLayoutName = $getLayoutName;
        $this->getLayoutCmsResource = $getLayoutCmsResource;
        $this->buildView = $buildView;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return View
     * @throws ViewDataNotFound|InvalidGetViewByRequest
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
//        echo("<pre>******\n");
//debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,8);
//        echo('</pre>');
        $publishedOnly = Property::get(
            $options,
            self::OPTION_PUBLISHED_ONLY,
            self::DEFAULT_PUBLISHED_ONLY
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

        return $this->buildView->__invoke(
            $request,
            $siteCmsResource,
            $pageCmsResource,
            $layoutCmsResource
        );
    }
}
