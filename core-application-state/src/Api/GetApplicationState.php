<?php

namespace Zrcms\CoreApplicationState\Api;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetApplicationState
{
    /**
     * @param ServerRequestInterface $request
     * @param array                  $appState
     * @param array                  $options
     *
     * @return array
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $appState = [],
        array $options = []
    ): array;
}
