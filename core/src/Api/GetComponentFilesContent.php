<?php

namespace Zrcms\Core\Api;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetComponentFilesContent
{
    /**
     * @param ServerRequestInterface $request
     * @param array                  $components
     * @param array                  $options
     *
     * @return string
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $components,
        array $options = []
    ): string;
}
