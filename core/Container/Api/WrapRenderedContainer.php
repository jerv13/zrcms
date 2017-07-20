<?php

namespace Zrcms\Core\Container\Api;

use Zrcms\Core\Container\Model\Container;

interface WrapRenderedContainer
{
    /**
     * @param string    $innerHtml
     * @param Container $container
     *
     * @return string
     */
    public function __invoke(
        string $innerHtml,
        Container $container
    ): string;
}
