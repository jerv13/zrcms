<?php

namespace Zrcms\Core\PageView\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\PageView\Model\PageView;
use Zrcms\Core\ThemeLayout\Api\Render\RenderThemeLayoutCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderPageViewBasic implements RenderPageView
{
    protected $getPageViewRenderData;

    protected $renderLayoutCmsResource;

    /**
     * @param GetPageViewRenderData        $getPageViewRenderData
     * @param RenderThemeLayoutCmsResource $renderLayoutCmsResource
     */
    public function __construct(
        GetPageViewRenderData $getPageViewRenderData,
        RenderThemeLayoutCmsResource $renderLayoutCmsResource
    ) {
        $this->getPageViewRenderData = $getPageViewRenderData;
        $this->renderLayoutCmsResource = $renderLayoutCmsResource;
    }

    /**
     * @param PageView|Content       $pageView
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string
     */
    public function __invoke(
        Content $pageView,
        ServerRequestInterface $request,
        array $options = []
    ): string
    {
        $renderData = $this->getPageViewRenderData->__invoke(
            $pageView,
            $request,
            $options
        );

        return $this->renderLayoutCmsResource->__invoke(
            $pageView->getThemeLayoutCmsResource(),
            $renderData
        );
    }
}
