<?php

namespace Rcms\Core\Container\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderContainer
{
    /**
     * @return string
     */
    public function __invoke(Container $container): string;
}
