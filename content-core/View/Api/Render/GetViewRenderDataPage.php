<?php

namespace Zrcms\ContentCore\View\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Page\Api\Render\GetPageContainerRenderData;
use Zrcms\ContentCore\Page\Api\Render\RenderPageContainer;
use Zrcms\ContentCore\View\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewRenderDataPage implements GetViewRenderData
{
    const RENDER_TAG_PAGE = '[page]';
    const SERVICE_ALIAS = 'page';

    /**
     * @var GetPageContainerRenderData
     */
    protected $getPageContainerRenderData;

    /**
     * @var RenderPageContainer
     */
    protected $renderPageContainer;

    /**
     * @param GetPageContainerRenderData $getPageContainerRenderData
     * @param RenderPageContainer        $renderPageContainer
     */
    public function __construct(
        GetPageContainerRenderData $getPageContainerRenderData,
        RenderPageContainer $renderPageContainer
    ) {
        $this->getPageContainerRenderData = $getPageContainerRenderData;
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
        $pageContainer = $view->getPage();

        $pageRenderData = $this->getPageContainerRenderData->__invoke(
            $view->getPage(),
            $request
        );

        $viewRenderData = $this->renderPageContainer->__invoke(
            $pageContainer,
            $pageRenderData
        );

        $viewRenderData = "<!-- <[page]> -->\n" . $viewRenderData . "\n<!-- </[page]> -->";

        return [
            self::RENDER_TAG_PAGE => $viewRenderData
        ];
    }
}
