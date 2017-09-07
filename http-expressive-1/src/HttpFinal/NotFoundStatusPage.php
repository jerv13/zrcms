<?php

namespace Zrcms\HttpExpressive1\HttpFinal;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\HttpExpressive1\Api\GetStatusPage;
use Zrcms\HttpExpressive1\HttpRender\RenderPage;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class NotFoundStatusPage
{
    /**
     * @var GetStatusPage
     */
    protected $getStatusPage;

    /**
     * @var RenderPage
     */
    protected $renderPage;

    /**
     * @param GetStatusPage $getStatusPage
     * @param RenderPage    $renderPage
     */
    public function __construct(
        GetStatusPage $getStatusPage,
        RenderPage $renderPage
    ) {
        $this->getStatusPage = $getStatusPage;
        $this->renderPage = $renderPage;
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
        $next = null
    ) {
        $statusPage = $this->getStatusPage->__invoke(
            $request,
            404
        );

        if (empty($statusPage)) {
            $reason = 'NOT FOUND: UNHANDLED REQUEST';

            return $response->withStatus(
                404,
                $reason
            )->withAddedHeader('reason-phrase', $reason);
        }

        $uri = $request->getUri();

        $uri = $uri->withPath($statusPage);

        $request->withUri($uri);

        $reason = 'NOT FOUND: UNHANDLED REQUEST: 404 PAGE MISSING: ' . $statusPage;
        $finalResponse = $response->withStatus(
            404,
            $reason
        )->withAddedHeader('reason-phrase', $reason);

        return $this->renderPage->__invoke(
            $request->withUri($uri),
            $response,
            function ($req, $res) use ($finalResponse) {
                return $finalResponse;
            }
        );
    }
}
