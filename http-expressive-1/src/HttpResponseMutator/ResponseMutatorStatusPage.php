<?php

namespace Zrcms\HttpExpressive1\HttpResponseMutator;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\HttpExpressive1\Api\GetStatusPage;
use Zrcms\HttpExpressive1\HttpRender\RenderPage;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseMutatorStatusPage implements ResponseMutator
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

        $uri = $uri->withPath($statusPage);

        $request->withUri($uri);

        return $this->renderPage->__invoke(
            $request->withUri($uri),
            $response,
            function ($req, $res) use ($response) {
                return $response;
            }
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
