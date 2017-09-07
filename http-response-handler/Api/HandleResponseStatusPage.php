<?php

namespace Zrcms\HttpResponseHandler\Api;

use Guzzle\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentCore\Basic\Api\Repository\FindBasicComponent;
use Zrcms\HttpExpressive1\Model\HttpExpressiveComponent;
use Zrcms\HttpResponseHandler\Exception\CanNotHandleResponse;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;
use Zrcms\Param\Param;

/**
 * @deprecated
 * @author James Jervis - https://github.com/jerv13
 */
class HandleResponseStatusPage implements HandleResponse
{
    /**
     * @var FindBasicComponent
     */
    protected $findBasicComponent;

    /**
     * @var HandleResponse
     */
    protected $handleResponse;

    /**
     * @param FindBasicComponent $findBasicComponent
     * @param HandleResponse     $handleResponse
     */
    public function __construct(
        FindBasicComponent $findBasicComponent,
        HandleResponse $handleResponse
    ) {
        $this->findBasicComponent = $findBasicComponent;
        $this->handleResponse = $handleResponse;
    }

    /**
     * @param ResponseInterface $response
     * @param array             $options
     *
     * @return ResponseInterface
     */
    public function __invoke(
        ResponseInterface $response,
        array $options = []
    ) {
        $status = $response->getStatusCode();

        /** @var HttpExpressiveComponent $component */
        $component = $this->findBasicComponent->__invoke(
            HttpExpressiveComponent::NAME
        );
        // @todo This can get the status pages from site or some other source to make this dynamic
        $statusPage = $component->findStatusPage($status);

        /** @var ServerRequestInterface $request */
        $request = Param::get(
            $options,
            HandleResponseOptions::REQUEST
        );

        $renderMiddleware = Param::get(
            $options,
            HandleResponseOptions::RENDER_MIDDLEWARE
        );

        $this->assertCanHandleResponse(
            $status,
            $statusPage,
            $request,
            $renderMiddleware
        );

        $uri = $request->getUri();

        $uri = $uri->withPath($statusPage);

        $request->withUri($uri);

        // this will stop loops
        $finalResponse = $response->withStatus(
            $response->getStatusCode(),
            $response->getReasonPhrase()
        );

        return $renderMiddleware->__invoke(
            $request->withUri($uri),
            $response,
            function ($req, $res) use ($finalResponse) {
                return $finalResponse;
            }
        );
    }

    /**
     * @param $status
     * @param $statusPage
     * @param $request
     * @param $renderMiddleware
     *
     * @return void
     * @throws CanNotHandleResponse
     */
    public function assertCanHandleResponse(
        $status,
        $statusPage,
        $request,
        $renderMiddleware
    ) {
        if (empty($statusPage)) {
            throw new CanNotHandleResponse(
                "No status page found for status: {$status}"
            );
        }

        if (!$request instanceof RequestInterface) {
            throw new CanNotHandleResponse(
                "Request is not valid"
            );
        }

        if (empty($renderMiddleware)) {
            throw new CanNotHandleResponse(
                "No render middleware provided"
            );
        }

        // @todo make sure is middleware
        //if (!method_exists($renderMiddleware, '__invoke')) {
        //    throw new CanNotHandleResponse(
        //        "No render middleware provided"
        //    );
        //}
    }
}
