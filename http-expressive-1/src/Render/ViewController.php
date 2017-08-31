<?php

namespace Zrcms\HttpExpressive1\Render;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\ContentCore\Page\Exception\PageNotFoundException;
use Zrcms\ContentCore\Site\Exception\SiteNotFoundException;
use Zrcms\ContentCore\View\Api\GetViewByRequest;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\HttpExpressive1\Model\RequestedPage;
use Zrcms\HttpResponseHandler\Api\HandleResponse;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ViewController
{
    /**
     * @param GetViewByRequest  $getViewByRequest
     * @param GetViewLayoutTags $getViewLayoutTags
     * @param RenderView        $renderView
     * @param HandleResponse    $handleResponse
     */
    public function __construct(
        GetViewByRequest $getViewByRequest,
        GetViewLayoutTags $getViewLayoutTags,
        RenderView $renderView,
        HandleResponse $handleResponse
    ) {
        $this->getViewByRequest = $getViewByRequest;
        $this->getViewLayoutTags = $getViewLayoutTags;
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
        $path = $request->getUri()->getPath();

        $additionalViewProperties = [
            RequestedPage::PROPERTY_PATH => $path,
        ];

        try {
            /** @var View $pageView */
            $pageView = $this->getViewByRequest->__invoke(
                $request,
                [
                    GetViewByRequest::OPTION_ADDITIONAL_PROPERTIES
                    => $additionalViewProperties
                ]
            );
        } catch (SiteNotFoundException $exception) {
            $response = new HtmlResponse(
                'SITE NOT FOUND',
                404
            );

            // Note: inject the right handler for your use case
            return $this->handleResponse->__invoke(
                $response,
                [
                    HandleResponseOptions::MESSAGE
                    => $exception->getMessage()
                ]
            );
        } catch (PageNotFoundException $exception) {
            $response = new HtmlResponse(
                'PAGE NOT FOUND',
                404
            );

            // Note: inject the right handler for your use case
            return $this->handleResponse->__invoke(
                $response,
                [
                    HandleResponseOptions::MESSAGE
                    => $exception->getMessage()
                ]
            );
        }

        $viewRenderTags = $this->getViewLayoutTags->__invoke(
            $pageView,
            $request
        );

        $html = $this->renderView->__invoke(
            $pageView,
            $viewRenderTags
        );

        $response = new HtmlResponse($html);

        return $this->handleResponse->__invoke(
            $response
        );
    }
}
