<?php

namespace Zrcms\HttpStatusPages\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zrcms\Http\Api\IsValidContentType;
use Zrcms\HttpViewRender\Response\RenderPage;
use Zrcms\HttpStatusPages\Api\GetStatusPage;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseMutatorStatusPage
{
    const QUERY_PARAM_FROM = 'redirect-from';
    /**
     * @todo These should be config driven list of ResponseMutator services
     * @var array
     */
    protected $statusPageTypeMethods
        = [
            '_default' => 'renderStatusPage',
            'redirect' => 'redirectStatusPage',
            'render' => 'renderStatusPage',
        ];

    /**
     * @var GetStatusPage
     */
    protected $getStatusPage;

    /**
     * @var RenderPage
     */
    protected $renderPage;

    /**
     * @var array
     */
    protected $validContentTypes;

    /**
     * @var array
     */
    protected $statusBlackList;

    /**
     * @param GetStatusPage $getStatusPage
     * @param RenderPage    $renderPage
     * @param array         $validContentTypes
     * @param array         $statusBlackList
     */
    public function __construct(
        GetStatusPage $getStatusPage,
        RenderPage $renderPage,
        array $validContentTypes = ['text/html', 'application/xhtml+xml', 'text/xml', 'application/xml', ''],
        array $statusBlackList = [200, 201, 204, 301, 302]
    ) {
        $this->getStatusPage = $getStatusPage;
        $this->renderPage = $renderPage;
        $this->validContentTypes = $validContentTypes;
        $this->statusBlackList = $statusBlackList;
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
        /** @var HtmlResponse $response */
        $response = $next($request, $response);

        if (!$this->canHandleResponse($response)) {
            return $response;
        }

        $statusCode = $response->getStatusCode();

        if ($statusCode == 200 && empty($response->getBody()->getContents())) {
            // @todo 204 No Content
            $statusCode = 404;
        };

        $statusPage = $this->getStatusPage->__invoke(
            $request,
            $statusCode
        );

        if (empty($statusPage)) {
            return $response;
        }

        $uri = $request->getUri();

        $originalQuery = $uri->getQuery();

        $fromQuery = self::QUERY_PARAM_FROM . '=' . urlencode($uri->getPath());

        if (!empty($originalQuery)) {
            $fromQuery = $originalQuery . '&' . $fromQuery;
        }

        $newUri = $uri->withPath($statusPage['path'])->withQuery($fromQuery);
        $newRequest = $request->withUri($newUri);

        $method = $this->statusPageTypeMethods['_default'];

        if (array_key_exists($statusPage['type'], $this->statusPageTypeMethods)) {
            $method = $this->statusPageTypeMethods[$statusPage['type']];
        }

        $response = $this->$method(
            $newRequest,
            $response
        );

        return $response->withAddedHeader('zrcms-response-mutator', 'ResponseMutatorStatusPage');
    }

    /**
     * @param ResponseInterface $response
     *
     * @return bool
     */
    protected function canHandleResponse(
        ResponseInterface $response
    ):bool {
        if (!IsValidContentType::invoke($response, $this->validContentTypes)) {
            return false;
        }

        if (empty($response->getBody()->getContents())) {
            return true;
        }

        if (in_array($response->getStatusCode(), $this->statusBlackList)) {
            return false;
        }

        return true;
    }

    /**
     * @todo This should be a separate, injectable ResponseMutator service
     *
     * @param ServerRequestInterface $newRequest
     * @param ResponseInterface      $response
     *
     * @return ResponseInterface
     */
    protected function renderStatusPage(
        ServerRequestInterface $newRequest,
        ResponseInterface $response
    ) {
        return $this->renderPage->__invoke(
            $newRequest,
            $response,
            function ($req, $res) use ($response) {
                return $response;
            }
        );
    }

    /**
     * @todo This should be a separate, injectable ResponseMutator service
     *
     * @param ServerRequestInterface $newRequest
     * @param ResponseInterface      $response
     *
     * @return RedirectResponse
     */
    protected function redirectStatusPage(
        ServerRequestInterface $newRequest,
        ResponseInterface $response
    ) {
        return new RedirectResponse(
            $newRequest->getUri()
        );
    }
}
