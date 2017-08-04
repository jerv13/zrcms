<?php

namespace Zrcms\HttpExpressive1\Render;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\ContentCore\Page\Exception\PageNotFoundException;
use Zrcms\ContentCore\Site\Exception\SiteNotFoundException;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderData;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Api\Repository\FindViewByRequest;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\HttpResponseHandler\Api\HandleResponse;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ViewController
{
    /**
     * @param FindViewByRequest $findViewByRequest
     * @param GetViewRenderData $getViewRenderData
     * @param RenderView        $renderView
     * @param HandleResponse    $handleResponse
     */
    public function __construct(
        FindViewByRequest $findViewByRequest,
        GetViewRenderData $getViewRenderData,
        RenderView $renderView,
        HandleResponse $handleResponse
    ) {
        $this->findViewByRequest = $findViewByRequest;
        $this->getViewRenderData = $getViewRenderData;
        $this->renderView = $renderView;
        $this->handleResponse = $handleResponse;
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
        // @todo TESTING ONLY
        $queryParams = $request->getQueryParams();

        if (!array_key_exists('zrcms', $queryParams)) {
            return $next(
                $request,
                $response
            );
        }
        // end TESTING

        $additionalViewProperties = [];

        try {
            /** @var View $pageView */
            $pageView = $this->findViewByRequest->__invoke(
                $request,
                $additionalViewProperties
            );
        } catch (SiteNotFoundException $exception) {
            // @todo Use a response service to generate these
            $response = new HtmlResponse('SITE NOT FOUND');

            return $this->handleResponse->__invoke(
                $request,
                $response->withStatus(404, 'SITE NOT FOUND'),
                [HandleResponseOptions::EXCEPTION => $exception]
            );
        } catch (PageNotFoundException $exception) {
            $response = new HtmlResponse('PAGE NOT FOUND');

            return $this->handleResponse->__invoke(
                $request,
                $response->withStatus(404, 'PAGE NOT FOUND'),
                [HandleResponseOptions::EXCEPTION => $exception]
            );
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
