<?php

namespace Zrcms\Core\Container\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Container\Model\Container;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetContainerRenderData
{
    /**
     * @param Container              $container
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string
     * @throws \Exception
     */
    public function __invoke(
        Container $container,
        ServerRequestInterface $request,
        array $options = []
    ): string;
}
