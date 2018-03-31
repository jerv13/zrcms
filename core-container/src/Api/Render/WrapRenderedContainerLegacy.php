<?php

namespace Zrcms\CoreContainer\Api\Render;

use Zrcms\CoreContainer\Model\Container;
use Zrcms\CorePage\Model\PageVersion;

class WrapRenderedContainerLegacy implements WrapRenderedContainer
{
    /**
     * @param string    $innerHtml
     * @param Container $container
     *
     * @return string
     * @throws \Exception
     */
    public function __invoke(
        string $innerHtml,
        Container $container
    ): string {
        $isPage = $container->getContext() == PageVersion::CONTAINER_CONTEXT;

        // @todo @bc REMOVE class: rcmContainer
        return "\n"
            . '<div class="content-container container-fluid rcmContainer"'
            . ' data-container-id="' . $container->getId() . '"'
            . ' data-container-name="' . $container->getName() . '"'
            . ' data-container-context="' . $container->getContext() . '"'
            // @todo @bc These attributes below are deprecated
            . ($isPage ? ' is-page-container="true"' : '')
            . ($isPage ? ' data-ispage="Y"' : '')
            . ">\n"
            . $innerHtml
            . "\n</div>\n";
    }
}
