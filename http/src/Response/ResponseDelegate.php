<?php

namespace Zrcms\Http\Response;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseDelegate implements DelegateInterface
{
    protected $response;

    /**
     * @param ResponseInterface $response
     */
    public function __construct(
        ResponseInterface $response
    ) {
        $this->response = $response;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request)
    {
        return $this->response;
    }
}
