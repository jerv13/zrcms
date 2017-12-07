<?php

namespace Zrcms\Core\Api\Render;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Render
{
    /**
     * @param ServerRequestInterface $request
     * @param array|mixed            $data
     * @param array                  $options
     *
     * @return string
     */
    public function __invoke(
        ServerRequestInterface $request,
        $data,
        array $options = []
    ): string;
}
