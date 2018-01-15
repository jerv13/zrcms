<?php

namespace Zrcms\Http\Api;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetRouteOptions
{
    /**
     * @param ServerRequestInterface $request
     *
     * @return array
     */
    public function __invoke(ServerRequestInterface $request): array;
}
