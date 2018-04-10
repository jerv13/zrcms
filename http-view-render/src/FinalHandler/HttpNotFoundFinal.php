<?php

namespace Zrcms\HttpViewRender\FinalHandler;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpNotFoundFinal implements MiddlewareInterface
{
    const DEFAULT_NOT_FOUND_STATUS = 404;

    protected $notFoundStatus;
    protected $debug;

    /**
     * @param int  $notFoundStatus
     * @param bool $debug
     */
    public function __construct(
        int $notFoundStatus = self::DEFAULT_NOT_FOUND_STATUS,
        bool $debug = false
    ) {
        $this->notFoundStatus = $notFoundStatus;
        $this->debug = $debug;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|Response
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        $response = new Response();

        if ($this->debug) {
            return $response
                ->withAddedHeader('zrcms-final', 'NotFoundFinal')
                ->withStatus($this->notFoundStatus);
        }

        return $response->withStatus($this->notFoundStatus);
    }
}
