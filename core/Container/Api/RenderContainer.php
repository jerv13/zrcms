<?php

namespace Zrcms\Core\Container\Api;

use Zrcms\Core\Container\Model\Container;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderContainer
{
    /**
     * @param Container $container
     * @param array     $containerRenderData
     * @param array     $options
     *
     * @return string
     */
    public function __invoke(
        Container $container,
        array $containerRenderData,
        array $options = []
    ): string;
}
