<?php

namespace Zrcms\HttpExpressive1\HttpRender;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\HttpExpressive1\Api\IsValidContentType;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseMutatorThemeLayoutWrapper
{
    /**
     * @var RenderPage
     */
    protected $renderPage;

    /**
     * @var array
     */
    protected $validContentTypes;

    /**
     * @param RenderPage    $renderPage
     * @param array         $validContentTypes
     */
    public function __construct(
        RenderPage $renderPage,
        array $validContentTypes = ['text/html', 'application/xhtml+xml', 'text/xml', 'application/xml']
    ) {
        $this->renderPage = $renderPage;
        $this->validContentTypes = $validContentTypes;
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
        /** @var HtmlResponse $response */
        $response = $next($request, $response);

        if (!$this->canHandleResponse($response)) {
            return $response;
        }

        // @todo write me

        return $response;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return bool
     */
    protected function canHandleResponse(
        ResponseInterface $response
    ):bool
    {
        if (!IsValidContentType::invoke($response, $this->validContentTypes)) {
            return false;
        }

        $contents = $response->getBody()->getContents();

        if (stripos($contents, '<html') !== false) {
            return false;
        }

        return true;
    }
}
