<?php

namespace Zrcms\HttpExpressive1\HttpResponseMutator;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zrcms\HttpExpressive1\Api\GetStatusPage;
use Zrcms\HttpExpressive1\HttpRender\RenderPage;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseMutatorStatusPage implements ResponseMutator
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
     * @param GetStatusPage $getStatusPage
     * @param RenderPage    $renderPage
     * @param array         $validContentTypes
     */
    public function __construct(
        GetStatusPage $getStatusPage,
        RenderPage $renderPage,
        array $validContentTypes = ['text/html', 'application/xhtml+xml', 'text/xml', 'application/xml', '']
    ) {
        $this->getStatusPage = $getStatusPage;
        $this->renderPage = $renderPage;
        $this->validContentTypes = $validContentTypes;
    }

    /**
     * __invoke
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param array                  $options
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $options = []
    ): ResponseInterface
    {
        if (!$this->isValidContentType($response)) {
            return $response;
        }

        $statusPage = $this->getStatusPage->__invoke(
            $request,
            $response->getStatusCode()
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

        return $this->$method(
            $newRequest,
            $response
        );
    }

    /**
     * @todo This should be a separate, injectable ResponseMutator service
     *
     * @param ServerRequestInterface $newRequest
     * @param ResponseInterface      $response
     * @param array                  $options
     *
     * @return ResponseInterface
     */
    protected function renderStatusPage(
        ServerRequestInterface $newRequest,
        ResponseInterface $response,
        array $options = []
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
     * @param array                  $options
     *
     * @return RedirectResponse
     */
    protected function redirectStatusPage(
        ServerRequestInterface $newRequest,
        ResponseInterface $response,
        array $options = []
    ) {
        return new RedirectResponse(
            $newRequest->getUri()
        );
    }

    /**
     * @todo Optimize me
     *
     * @param ResponseInterface $response
     *
     * @return bool
     */
    protected function isValidContentType(ResponseInterface $response): bool
    {
        $contentTypeLine = $response->getHeaderLine('content-type');

        $parts = explode(',', $contentTypeLine);

        foreach ($parts as $part) {
            $subParts = explode(';', $part);
            foreach ($subParts as $subPart) {
                if (in_array($subPart, $this->validContentTypes)) {
                    return true;
                }
            }
        }

        return false;
    }
}
