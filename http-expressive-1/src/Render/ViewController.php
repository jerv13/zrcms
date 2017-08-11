<?php

namespace Zrcms\HttpExpressive1\Render;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\ContentCore\Page\Exception\PageNotFoundException;
use Zrcms\ContentCore\Site\Exception\SiteNotFoundException;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
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
     * @param GetViewLayoutTags $getViewLayoutTags
     * @param RenderView $renderView
     * @param HandleResponse $handleResponse
     */
    public function __construct(
        FindViewByRequest $findViewByRequest,
        GetViewLayoutTags $getViewLayoutTags,
        RenderView $renderView,
        HandleResponse $handleResponse
    ) {
        $this->findViewByRequest = $findViewByRequest;
        $this->getViewLayoutTags = $getViewLayoutTags;
        $this->renderView = $renderView;
        $this->handleResponse = $handleResponse;
    }

    /**
     * __invoke
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
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

//        if (!array_key_exists('zrcms', $queryParams)) {
//            return $next(
//                $request,
//                $response
//            );
//        }
        // end TESTING

        if ($request->getUri()->getPath() === '/') {
            $request = $request->withUri($request->getUri()->withPath('/index'));
        }

        $additionalViewProperties = [];

        try {
            /** @var View $pageView */
            $pageView = $this->findViewByRequest->__invoke(
                $request,
                $additionalViewProperties
            );
        } catch (SiteNotFoundException $exception) {
            return $next($request, $response);
//
//            // @todo Use a response service to generate these
//            $response = new HtmlResponse('SITE NOT FOUND');
//
//            return $this->handleResponse->__invoke(
//                $request,
//                $response->withStatus(404, 'SITE NOT FOUND'),
//                [HandleResponseOptions::EXCEPTION => $exception]
//            );
        } catch (PageNotFoundException $exception) {
            return $next($request, $response);

//            $response = new HtmlResponse('PAGE NOT FOUND');
//
//            return $this->handleResponse->__invoke(
//                $request,
//                $response->withStatus(404, 'PAGE NOT FOUND'),
//                [HandleResponseOptions::EXCEPTION => $exception]
//            );
        }

        $viewRenderTags = $this->getViewLayoutTags->__invoke(
            $pageView,
            $request
        );

        $html = $this->renderView->__invoke(
            $pageView,
            $viewRenderTags
        );

        return new HtmlResponse($html);
    }
}
