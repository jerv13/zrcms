<?php

namespace Zrcms\Core\Container\Api;

use Zrcms\Core\Container\Model\ContainerRevision;

interface WrapRenderedContainer
{
    /**
     * @param string            $innerHtml
     * @param ContainerRevision $container
     *
     * @return string
     */
    public function __invoke(
        string $innerHtml,
        ContainerRevision $container
    ): string;
}
