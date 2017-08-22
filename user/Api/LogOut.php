<?php

namespace Zrcms\User\Api;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface LogOut
{
    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return bool Success
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): bool;
}
