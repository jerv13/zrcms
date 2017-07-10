<?php

namespace Zrcms\Core\Container\Api;

interface WrapRenderedContainer
{
    public function __invoke(string $innerHtml, Container $container): string
}
