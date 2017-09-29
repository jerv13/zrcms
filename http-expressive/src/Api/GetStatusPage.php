<?php

namespace Zrcms\HttpExpressive\Api;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetStatusPage
{
    /**
     * @param ServerRequestInterface $request
     * @param int                    $status
     *
     * @return null|string
     */
    public function __invoke(
        ServerRequestInterface $request,
        int $status
    );
}
