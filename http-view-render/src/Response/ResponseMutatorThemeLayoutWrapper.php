<?php

namespace Zrcms\HttpViewRender\Response;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Stream;
use Zrcms\CoreView\Api\Render\GetViewLayoutTags;
use Zrcms\CoreView\Api\Render\RenderView;
use Zrcms\CoreView\Api\ViewBuilder\BuildView;
use Zrcms\CoreView\Api\ViewBuilder\BuildViewHtmlPage;
use Zrcms\CoreView\Api\ViewBuilder\DetermineViewStrategyHtmlPage;
use Zrcms\CoreView\Exception\PageNotFound;
use Zrcms\CoreView\Exception\SiteNotFound;
use Zrcms\CoreView\Model\View;
use Zrcms\Http\Response\ZrcmsHtmlResponse;
use Zrcms\HttpViewRender\Router\LayoutThemeRouter;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseMutatorThemeLayoutWrapper
{
    protected $buildViewHtmlPage;
    protected $getViewLayoutTags;
    protected $renderView;
    protected $layoutThemeRouter;
    protected $debug;

    /**
     * @param BuildViewHtmlPage $buildViewHtmlPage
     * @param GetViewLayoutTags        $getViewLayoutTags
     * @param RenderView               $renderView
     * @param LayoutThemeRouter        $layoutThemeRouter
     * @param bool                     $debug
     */
    public function __construct(
        BuildViewHtmlPage $buildViewHtmlPage,
        GetViewLayoutTags $getViewLayoutTags,
        RenderView $renderView,
        LayoutThemeRouter $layoutThemeRouter,
        bool $debug = false
    ) {
        $this->buildViewHtmlPage = $buildViewHtmlPage;
        $this->getViewLayoutTags = $getViewLayoutTags;
        $this->renderView = $renderView;
        $this->layoutThemeRouter = $layoutThemeRouter;
        $this->debug = $debug;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ResponseInterface|HtmlResponse|ZrcmsHtmlResponse|static
     * @throws \Zrcms\CoreView\Exception\ViewDataNotFound
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        /** @var HtmlResponse|ZrcmsHtmlResponse $response */
        $response = $next($request, $response);

        if (!$this->canHandleResponse($request, $response)) {
            return $response;
        }

        $options = $this->getProperties($response);
        $options[BuildView::OPTION_VIEW_STRATEGY] = DetermineViewStrategyHtmlPage::STRATEGY;

        try {
            /** @var View $view */
            $view = $this->buildViewHtmlPage->__invoke(
                $request,
                $options
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

        $body = new Stream('php://temp', 'wb+');
        $body->write($html);
        $body->rewind();

        if ($this->debug) {
            return $response->withBody($body)
                ->withAddedHeader('zrcms-response-mutator', 'ResponseMutatorThemeLayoutWrapper');
        }

        return $response->withBody($body);
    }

    /**
     * @param ResponseInterface $response
     *
     * @return array
     */
    protected function getProperties(ResponseInterface $response)
    {
        $properties = [];
        if ($response instanceof ZrcmsHtmlResponse) {
            $properties = $response->getProperties();
        }

        $body = $response->getBody();
        $body->rewind();

        $contents = $body->getContents();

        $properties[BuildViewHtmlPage::OPTION_HTML] = $contents;

        return $properties;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return bool
     */
    protected function canHandleResponse(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): bool {
        if ($response instanceof ZrcmsHtmlResponse) {
            $renderLayout = $response->findProperty(
                ZrcmsHtmlResponse::PROPERTY_RENDER_LAYOUT,
                ZrcmsHtmlResponse::DEFAULT_RENDER_LAYOUT
            );

            return $renderLayout;
        }

        $routeResult = $this->layoutThemeRouter->match($request);

        return $routeResult->isSuccess();
    }
}
