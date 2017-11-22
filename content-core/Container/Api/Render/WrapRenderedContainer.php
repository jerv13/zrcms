<?php

namespace Zrcms\ContentCore\Container\Api\Render;

use Zrcms\ContentCore\Container\Model\Container;

/**
 * @author Rod Mcnew
 */
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
