<?php

namespace Zrcms\HttpExpressive1\HttpRender;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\HttpExpressive1\HttpAlways\RequestWithView;
use Zrcms\HttpResponseHandler\Api\HandleResponse;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ViewController
{
    /**
     * @param GetViewLayoutTags $getViewLayoutTags
     * @param RenderView        $renderView
     * @param HandleResponse    $handleResponse
     */
    public function __construct(
        GetViewLayoutTags $getViewLayoutTags,
        RenderView $renderView,
        HandleResponse $handleResponse
    ) {
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
        $view = $request->getAttribute(
            RequestWithView::ATTRIBUTE_VIEW
        );

        if (empty($view)) {
            $response = new HtmlResponse(
                RequestWithView::ATTRIBUTE_HTTP_MESSAGE,
                RequestWithView::ATTRIBUTE_HTTP_STATUS
            );

            return $this->handleResponse(
                $response,
                [
                    HandleResponseOptions::MESSAGE
                    => $request->getAttribute(RequestWithView::ATTRIBUTE_MESSAGE),
                    HandleResponseOptions::NEXT
                    => $next,
                    HandleResponseOptions::REQUEST
                    => $request,
                    HandleResponseOptions::RENDER_MIDDLEWARE
                    => $this,
                ]
            );
        }

        $viewRenderTags = $this->getViewLayoutTags->__invoke(
            $view,
            $request
        );

        $html = $this->renderView->__invoke(
            $view,
            $viewRenderTags
        );

        $response = new HtmlResponse($html);

        return $this->handleResponse(
            $response
        );
    }

    /**
     * @param ResponseInterface $response
     * @param array             $options
     *
     * @return ResponseInterface
     */
    protected function handleResponse(
        ResponseInterface $response,
        array $options = []
    ) {
        return $this->handleResponse->__invoke(
            $response,
            $options
        );
    }
}
