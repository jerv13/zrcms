<?php

namespace Zrcms\Core\Partial\Api;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetPartialRenderData
{
    /**
     * @param ServerRequestInterface $request
     * @param array                  $params
     * @param array                  $options
     *
     * @return array
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $params = [],
        array $options = []
    ): array;
}
