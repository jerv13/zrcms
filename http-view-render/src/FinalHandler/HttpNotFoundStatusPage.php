<?php

namespace Zrcms\HttpViewRender\FinalHandler;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\Http\Response\ResponseDelegate;
use Zrcms\HttpStatusPages\Api\GetStatusPage;
use Zrcms\HttpViewRender\Response\RenderPage;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpNotFoundStatusPage implements MiddlewareInterface
{
    const DEFAULT_NOT_FOUND_STATUS = 404;

    protected $getStatusPage;
    protected $renderPage;
    protected $notFoundStatus;
    protected $debug;

    /**
     * @param GetStatusPage $getStatusPage
     * @param RenderPage    $renderPage
     * @param int           $notFoundStatus
     * @param bool          $debug
     */
    public function __construct(
        GetStatusPage $getStatusPage,
        RenderPage $renderPage,
        int $notFoundStatus = self::DEFAULT_NOT_FOUND_STATUS,
        bool $debug = false
    ) {
        $this->getStatusPage = $getStatusPage;
        $this->renderPage = $renderPage;
        $this->notFoundStatus = $notFoundStatus;
        $this->debug = $debug;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|HtmlResponse|static
     * @throws \Zrcms\CoreView\Exception\InvalidGetViewByRequest
     * @throws \Zrcms\CoreView\Exception\ViewDataNotFound
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        $statusPage = $this->getStatusPage->__invoke(
            $request,
            $this->notFoundStatus
        );

        if (empty($statusPage)) {
            return new HtmlResponse(
                '',
                $this->notFoundStatus,
                ['reason-phrase' => 'NOT FOUND: UNHANDLED REQUEST']
            );
        }

        $requestUri = $request->getUri();

        $uri = $requestUri->withPath($statusPage['path']);

        $delegate = new ResponseDelegate(
            new HtmlResponse(
                '',
                $this->notFoundStatus,
                ['reason-phrase' => 'NOT FOUND: UNHANDLED REQUEST: 404 PAGE MISSING: ' . $statusPage]
            )
        );

        $response = $this->renderPage->process(
            $request->withUri($uri),
            $delegate
        );

        if ($this->debug) {
            return $response->withAddedHeader('zrcms-final', 'NotFoundStatusPage');
        }

        return $response;
    }
}
