<?php

namespace Zrcms\HttpViewRender\Response;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\CoreView\Api\GetViewByRequest;
use Zrcms\CoreView\Api\Render\GetViewLayoutTags;
use Zrcms\CoreView\Api\Render\RenderView;
use Zrcms\CoreView\Exception\PageNotFound;
use Zrcms\CoreView\Exception\SiteNotFound;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderPage implements MiddlewareInterface
{
    protected $getViewByRequest;
    protected $getViewLayoutTags;
    protected $renderView;
    protected $getViewByRequestOptions;

    /**
     * @param GetViewByRequest  $getViewByRequest
     * @param GetViewLayoutTags $getViewLayoutTags
     * @param RenderView        $renderView
     * @param array             $getViewByRequestOptions
     */
    public function __construct(
        GetViewByRequest $getViewByRequest,
        GetViewLayoutTags $getViewLayoutTags,
        RenderView $renderView,
        array $getViewByRequestOptions = []
    ) {
        $this->getViewByRequest = $getViewByRequest;
        $this->getViewLayoutTags = $getViewLayoutTags;
        $this->renderView = $renderView;
        $this->getViewByRequestOptions = $getViewByRequestOptions;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|HtmlResponse
     * @throws \Zrcms\CoreView\Exception\InvalidGetViewByRequest
     * @throws \Zrcms\CoreView\Exception\ViewDataNotFound
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        try {
            /** @var View $view */
            $view = $this->getViewByRequest->__invoke(
                $request,
                $this->getViewByRequestOptions
            );
        } catch (SiteNotFound $exception) {
            return new HtmlResponse(
                'NOT FOUND',
                404,
                ['reason-phrase' => 'NOT FOUND: SITE']
            );
        } catch (PageNotFound $exception) {
            return new HtmlResponse(
                'NOT FOUND',
                404,
                ['reason-phrase' => 'NOT FOUND: PAGE']
            );
        }

        if (empty($view)) {
            return new HtmlResponse(
                'NOT FOUND',
                404,
                ['reason-phrase' => 'NOT FOUND: NO VIEW']
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

        return new HtmlResponse($html);
    }
}
