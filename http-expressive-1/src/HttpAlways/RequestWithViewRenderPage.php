<?php

namespace Zrcms\HttpExpressive1\HttpAlways;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Api\Render\RenderView;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithViewRenderPage
{
    /**
     * @param GetViewLayoutTags $getViewLayoutTags
     * @param RenderView        $renderView
     */
    public function __construct(
        GetViewLayoutTags $getViewLayoutTags,
        RenderView $renderView
    ) {
        $this->getViewLayoutTags = $getViewLayoutTags;
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
        $view = $request->getAttribute(
            RequestWithView::ATTRIBUTE_VIEW
        );

        if (empty($view)) {
            return $next($request, $response);
        }

        $viewRenderTags = $this->getViewLayoutTags->__invoke(
            $view,
            $request
        );



        $html = $this->renderView->__invoke(
            $view,
            $viewRenderTags
        );

        return new HtmlResponse($html);
    }
}
