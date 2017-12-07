<?php

namespace Zrcms\CoreContainer\Api\Render;

use Zrcms\CoreContainer\Model\Container;

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
