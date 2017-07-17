<?php

namespace Zrcms\Core\PageView\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\Layout\Api\Render\RenderLayout;
use Zrcms\Core\Layout\Api\Render\RenderLayoutCmsResource;
use Zrcms\Core\PageView\Model\PageView;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderPageViewBasic implements RenderPageView
{
    protected $getPageViewRenderData;

    protected $renderLayoutCmsResource;

    /**
     * @param GetPageViewRenderData   $getPageViewRenderData
     * @param RenderLayoutCmsResource $renderLayoutCmsResource
     */
    public function __construct(
        GetPageViewRenderData $getPageViewRenderData,
        RenderLayoutCmsResource $renderLayoutCmsResource
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
            $pageView->getLayoutCmsResource(),
            $renderData
        );
    }
}
