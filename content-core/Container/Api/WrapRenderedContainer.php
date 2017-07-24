<?php

namespace Zrcms\ContentCore\Container\Api;

use Zrcms\ContentCore\Container\Model\Container;

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
