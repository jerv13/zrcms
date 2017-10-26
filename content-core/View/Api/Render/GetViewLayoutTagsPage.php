<?php

namespace Zrcms\ContentCore\View\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Page\Api\Render\GetPageRenderTags;
use Zrcms\ContentCore\Page\Model\PageVersion;
use Zrcms\ContentCore\View\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTagsPage implements GetViewLayoutTags
{
    const RENDER_TAG_PAGE = 'page';
    const SERVICE_ALIAS = 'page';

    /**
     * @var GetPageRenderTags
     */
    protected $getPageRenderTags;

    /**
     * @param GetPageRenderTags $getPageRenderTags
     */
    public function __construct(
        GetPageRenderTags $getPageRenderTags
    ) {
        $this->getPageRenderTags = $getPageRenderTags;
    }

    /**
     * @param View|Content           $view
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        Content $view,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        /** @var PageVersion $page */
        $page = $view->getPageCmsResource()->getContentVersion();

        $pageRenderTags = $this->getPageRenderTags->__invoke(
            $page,
            $request
        );

        return [
            self::RENDER_TAG_PAGE => $pageRenderTags
        ];
    }
}
