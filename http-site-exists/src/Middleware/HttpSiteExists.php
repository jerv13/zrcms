<?php

namespace Zrcms\HttpSiteExists\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\CoreSite\Api\GetSiteCmsResourceByRequest;
use Zrcms\CoreSite\Model\SiteCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpSiteExists implements MiddlewareInterface
{
    protected $getSiteCmsResourceByRequest;
    protected $notFoundStatus;
    protected $notFoundMessage = '';
    protected $notFoundHeaders = [];

    /**
     * @param GetSiteCmsResourceByRequest $getSiteCmsResourceByRequest
     * @param int                         $notFoundStatus
     * @param string                      $notFoundMessage
     * @param array                       $notFoundHeaders
     */
    public function __construct(
        GetSiteCmsResourceByRequest $getSiteCmsResourceByRequest,
        $notFoundStatus = 404,
        $notFoundMessage = '',
        $notFoundHeaders = []
    ) {
        $this->getSiteCmsResourceByRequest = $getSiteCmsResourceByRequest;
        $this->notFoundStatus = $notFoundStatus;
        $this->notFoundMessage = $notFoundMessage;
        $this->notFoundHeaders = $notFoundHeaders;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|HtmlResponse
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        /** @var SiteCmsResource $siteCmsResource */
        $siteCmsResource = $this->getSiteCmsResourceByRequest->__invoke(
            $request
        );

        if (empty($siteCmsResource)) {
            return new HtmlResponse(
                $this->notFoundMessage,
                $this->notFoundStatus,
                $this->notFoundHeaders
            );
        }

        return $delegate->process($request);
    }
}
