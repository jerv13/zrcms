<?php

namespace Zrcms\HttpExpressive1\Render;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\HttpExpressive1\Api\GetStatusSitePropertyPagePath;
use Zrcms\HttpResponseHandler\Api\HandleResponse;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ViewControllerFallbackPage
{
    /**
     * @var GetStatusSitePropertyPagePath
     */
    protected $getStatusSitePropertyPagePath;

    /**
     * @var HandleResponse
     */
    protected $handleResponse;

    /**
     * @var ViewController
     */
    protected $viewController;

    /**
     * @param GetStatusSitePropertyPagePath $getStatusSitePropertyPagePath
     * @param HandleResponse                $handleResponse
     * @param ViewController                $viewController
     */
    public function __construct(
        GetStatusSitePropertyPagePath $getStatusSitePropertyPagePath,
        HandleResponse $handleResponse,
        $viewController
    ) {
        $this->getStatusSitePropertyPagePath = $getStatusSitePropertyPagePath;
        $this->handleResponse = $handleResponse;
        $this->viewController = $viewController;
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
        $uri = $request->getUri();
        $path = $uri->getPath();
        if ($path === '/') {
            $request = $request->withUri($request->getUri()->withPath('/index'));
        }

        $status = $response->getStatusCode();
        // If there is no status or 200 then we use 404,
        // any other status should have returned before getting here
        $status = ($status == 200 || empty($status)) ? '404' : (string)$status;

        $sitePropertyPagePath = $this->getStatusSitePropertyPagePath->__invoke($status);

        if (empty($sitePropertyPagePath)) {
            $response = new HtmlResponse('PAGE NOT FOUND');

            return $this->handleResponse->__invoke(
                $request,
                $response->withStatus(404, 'PAGE NOT FOUND'),
                [
                    HandleResponseOptions::EXCEPTION
                    => new \Exception('SitePropertyPagePath is not set for status: ' . $status)
                ]
            );
        }

        $uri = $uri->withPath($sitePropertyPagePath);

        $request->withUri($uri);

        return $this->viewController->__invoke(
            $request->withUri($uri),
            $response,
            function ($req, $res) use ($response) {
                return $response->withStatus(404, 'PAGE NOT FOUND');
            }
        );
    }
}
