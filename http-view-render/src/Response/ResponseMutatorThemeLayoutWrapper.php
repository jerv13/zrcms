<?php

namespace Zrcms\HttpViewRender\Response;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Stream;
use Zrcms\CorePage\Exception\PageNotFound;
use Zrcms\CoreSite\Exception\SiteNotFound;
use Zrcms\CoreView\Api\GetViewByRequestHtmlPage;
use Zrcms\CoreView\Api\Render\GetViewLayoutTags;
use Zrcms\CoreView\Api\Render\RenderView;
use Zrcms\CoreView\Model\View;
use Zrcms\Http\Response\ZrcmsHtmlResponse;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseMutatorThemeLayoutWrapper
{
    protected $getViewByRequestHtmlPage;
    protected $getViewLayoutTags;
    protected $renderView;
    protected $pageLayoutConfig;
    protected $debug;

    /**
     * @param GetViewByRequestHtmlPage $getViewByRequestHtmlPage
     * @param GetViewLayoutTags        $getViewLayoutTags
     * @param RenderView               $renderView
     * @param array                    $pageLayoutConfig
     * @param bool                     $debug
     */
    public function __construct(
        GetViewByRequestHtmlPage $getViewByRequestHtmlPage,
        GetViewLayoutTags $getViewLayoutTags,
        RenderView $renderView,
        array $pageLayoutConfig = [],
        bool $debug = false
    ) {
        $this->getViewByRequestHtmlPage = $getViewByRequestHtmlPage;
        $this->getViewLayoutTags = $getViewLayoutTags;
        $this->renderView = $renderView;
        $this->pageLayoutConfig = $pageLayoutConfig;
        $this->debug = $debug;
    }

    /**
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
        /** @var HtmlResponse|ZrcmsHtmlResponse $response */
        $response = $next($request, $response);

        if (!$this->canHandleResponse($request, $response)) {
            return $response;
        }

        $options = $this->getProperties($response);

        try {
            /** @var View $view */
            $view = $this->getViewByRequestHtmlPage->__invoke(
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

        $properties[GetViewByRequestHtmlPage::OPTION_HTML] = $contents;

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
    ):bool {
        if ($response instanceof ZrcmsHtmlResponse) {
            $renderLayout = $response->findProperty(
                ZrcmsHtmlResponse::PROPERTY_RENDER_LAYOUT,
                ZrcmsHtmlResponse::DEFAULT_RENDER_LAYOUT
            );

            return $renderLayout;
        }

        return Param::getBool(
            $this->pageLayoutConfig,
            $request->getUri()->getPath(),
            false
        );
    }
}
