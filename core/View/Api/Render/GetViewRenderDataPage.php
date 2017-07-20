<?php

namespace Zrcms\Core\View\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\Page\Api\Render\GetPageContainerRenderData;
use Zrcms\Core\Page\Api\Render\RenderPageContainer;
use Zrcms\Core\Page\Model\PropertiesPage;
use Zrcms\Core\View\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewRenderDataPage implements GetViewRenderData
{
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
        $viewRenderData = [];

        $containerNs = PropertiesPage::RENDER_TAG;

        $pageContainer = $view->getPage();

        $pageRenderData = $this->getPageContainerRenderData->__invoke(
            $view->getPage(),
            $request
        );

        $viewRenderData[$containerNs] = $this->renderPageContainer->__invoke(
            $pageContainer,
            $pageRenderData
        );

        return $viewRenderData;
    }
}
