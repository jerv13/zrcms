<?php

namespace Zrcms\HttpViewRender\FinalHandler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class NotFoundFinal
{
    protected $notFoundStatus = 404;
    protected $debug;

    /**
     * @param int  $notFoundStatus
     * @param bool $debug
     */
    public function __construct(
        int $notFoundStatus = 404,
        bool $debug = false
    ) {
        $this->notFoundStatus = $notFoundStatus;
        $this->debug = $debug;
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
        $next = null
    ) {
        if ($this->debug) {
            return $response
                ->withAddedHeader('zrcms-final', 'NotFoundFinal')
                ->withStatus($this->notFoundStatus);
        }

        return $response->withStatus($this->notFoundStatus);
    }
}
