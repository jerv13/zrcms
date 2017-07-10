<?php

namespace Zrcms\Core\Container\Api;

use Zrcms\Core\Container\Model\Container;

interface WrapRenderedContainer
{
    public function __invoke(string $innerHtml, Container $container): string;
}
