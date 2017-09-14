<?php

namespace Zrcms\HttpExpressive1\HttpRender\FinalHandler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
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
            return new HtmlResponse(
                '',
                404,
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
                    404,
                    ['reason-phrase' => 'NOT FOUND: UNHANDLED REQUEST: 404 PAGE MISSING: ' . $statusPage]
                );
            }
        );

        return $response->withAddedHeader('zrcms-final','NotFoundStatusPage');
    }
}
