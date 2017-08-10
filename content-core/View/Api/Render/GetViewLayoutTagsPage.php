<?php

namespace Zrcms\ContentCore\View\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Page\Api\Render\GetPageContainerRenderTags;
use Zrcms\ContentCore\Page\Api\Render\RenderPageContainer;
use Zrcms\ContentCore\Page\Model\PageContainerVersion;
use Zrcms\ContentCore\View\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTagsPage implements GetViewLayoutTags
{
    const RENDER_TAG_PAGE = '[page]';
    const SERVICE_ALIAS = 'page';

    /**
     * @var GetPageContainerRenderTags
     */
    protected $getPageContainerRenderTags;

    /**
     * @var RenderPageContainer
     */
    protected $renderPageContainer;

    /**
     * @param GetPageContainerRenderTags $getPageContainerRenderTags
     * @param RenderPageContainer        $renderPageContainer
     */
    public function __construct(
        GetPageContainerRenderTags $getPageContainerRenderTags,
        RenderPageContainer $renderPageContainer
    ) {
        $this->getPageContainerRenderTags = $getPageContainerRenderTags;
        $this->renderPageContainer = $renderPageContainer;
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
        /** @var PageContainerVersion $pageContainer */
        $pageContainer = $view->getPage();

        $pageRenderTags = $this->getPageContainerRenderTags->__invoke(
            $pageContainer,
            $request
        );

        $html = $this->renderPageContainer->__invoke(
            $pageContainer,
            $pageRenderTags
        );

        $html = "<!-- <[page]> -->\n" . $html . "\n<!-- </[page]> -->";

        return [
            self::RENDER_TAG_PAGE => $html
        ];
    }
}
