<?php

namespace Zrcms\HttpViewRender\FinalHandler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\HttpStatusPages\Api\GetStatusPage;
use Zrcms\HttpViewRender\Response\RenderPage;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpNotFoundStatusPage
{
    protected $getStatusPage;
    protected $renderPage;
    protected $notFoundStatus = 404;
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
        int $notFoundStatus = 404,
        bool $debug = false
    ) {
        $this->getStatusPage = $getStatusPage;
        $this->renderPage = $renderPage;
        $this->notFoundStatus = $notFoundStatus;
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
        $next = null
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

        $uri = $request->getUri();

        $uri = $uri->withPath($statusPage['path']);

        $request->withUri($uri);

        $response = $this->renderPage->__invoke(
            $request->withUri($uri),
            $response,
            function ($req, $res) use ($statusPage) {
                return new HtmlResponse(
                    '',
                    $this->notFoundStatus,
                    ['reason-phrase' => 'NOT FOUND: UNHANDLED REQUEST: 404 PAGE MISSING: ' . $statusPage]
                );
            }
        );

        if ($this->debug) {
            return $response->withAddedHeader('zrcms-final', 'NotFoundStatusPage');
        }

        return $response;
    }
}
