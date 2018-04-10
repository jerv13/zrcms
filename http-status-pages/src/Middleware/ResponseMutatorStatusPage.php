<?php

namespace Zrcms\HttpStatusPages\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zrcms\Http\Api\IsValidContentType;
use Zrcms\HttpStatusPages\Api\GetStatusPage;
use Zrcms\HttpViewRender\Response\RenderPage;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseMutatorStatusPage implements MiddlewareInterface
{
    const ATTRIBUTE_REQUEST_URI = 'zrcms-request-uri-status-page';

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

    protected $getStatusPage;
    protected $renderPage;
    protected $validContentTypes;
    protected $statusBlackList;
    protected $debug;

    /**
     * @param GetStatusPage $getStatusPage
     * @param RenderPage    $renderPage
     * @param array         $validContentTypes
     * @param array         $statusBlackList
     * @param bool          $debug
     */
    public function __construct(
        GetStatusPage $getStatusPage,
        RenderPage $renderPage,
        array $validContentTypes = ['text/html', 'application/xhtml+xml', 'text/xml', 'application/xml', ''],
        array $statusBlackList = [200, 201, 204, 301, 302],
        bool $debug = false
    ) {
        $this->getStatusPage = $getStatusPage;
        $this->renderPage = $renderPage;
        $this->validContentTypes = $validContentTypes;
        $this->statusBlackList = $statusBlackList;
        $this->debug = $debug;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|HtmlResponse|static
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        /** @var HtmlResponse $response */
        $response = $delegate->process($request);

        if (!$this->canHandleResponse($response)) {
            return $response;
        }

        $statusPage = $this->getStatusPage->__invoke(
            $request,
            $response->getStatusCode()
        );

        if (empty($statusPage)) {
            return $response;
        }

        $requestUri = $request->getUri();

        $originalQuery = $requestUri->getQuery();

        $fromQuery = self::QUERY_PARAM_FROM . '=' . urlencode($requestUri->getPath());

        if (!empty($originalQuery)) {
            $fromQuery = $originalQuery . '&' . $fromQuery;
        }

        $newUri = $requestUri->withPath($statusPage['path'])->withQuery($fromQuery);
        $newRequest = $request->withUri($newUri)->withAttribute(
            static::ATTRIBUTE_REQUEST_URI,
            $requestUri
        );

        $method = $this->statusPageTypeMethods['_default'];

        if (array_key_exists($statusPage['type'], $this->statusPageTypeMethods)) {
            $method = $this->statusPageTypeMethods[$statusPage['type']];
        }

        $response = $this->$method(
            $newRequest,
            $response
        );

        if ($this->debug) {
            return $response->withAddedHeader('zrcms-response-mutator', 'ResponseMutatorStatusPage');
        }

        return $response;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return bool
     */
    protected function canHandleResponse(
        ResponseInterface $response
    ): bool {
        if (!IsValidContentType::invoke($response, $this->validContentTypes)) {
            return false;
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
     * @throws \Exception
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
