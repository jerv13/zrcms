<?php

namespace Zrcms\HttpViewRender\Request;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\CoreView\Api\Render\GetViewLayoutTags;
use Zrcms\CoreView\Api\Render\RenderView;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithViewRenderPage implements MiddlewareInterface
{
    protected $getViewLayoutTags;
    protected $renderView;

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
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|HtmlResponse
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        /** @var View $view */
        $view = $request->getAttribute(
            RequestWithView::ATTRIBUTE_VIEW
        );

        if (empty($view)) {
            return $delegate->process($request);
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
