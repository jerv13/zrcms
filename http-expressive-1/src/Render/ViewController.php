<?php

namespace Zrcms\ContentCore\PageView\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\ContentCore\Page\Exception\PageNotFoundException;
use Zrcms\ContentCore\Site\Exception\SiteNotFoundException;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderData;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Api\Repository\FindViewByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ViewController
{
    public function __construct(
        FindViewByRequest $findViewByRequest,
        GetViewRenderData $getViewRenderData,
        RenderView $renderView
    ) {
        $this->findViewByRequest = $findViewByRequest;
        $this->getViewRenderData = $getViewRenderData;
        $this->renderView = $renderView;
    }

    /**
     * __invoke
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        try {
            $pageView = $this->findViewByRequest->__invoke(
                $request
            );
        } catch (SiteNotFoundException $exception) {
            return $response->withStatus(404, 'SITE NOT FOUND');
        } catch (PageNotFoundException $exception) {
            return $response->withStatus(404, 'PAGE NOT FOUND');
        }

        $viewRenderData = $this->getViewRenderData->__invoke(
            $pageView,
            $request
        );

        $html = $this->renderView->__invoke(
            $pageView,
            $viewRenderData
        );

        return new HtmlResponse($html);
    }
}
