<?php

namespace Zrcms\ContentCore\Container\Api;

use Zrcms\ContentCore\Container\Model\Container;
use Zrcms\ContentCore\Page\Model\PageContainerVersion;

class WrapRenderedContainerLegacy implements WrapRenderedContainer
{
    /**
     * @param string                         $innerHtml
     * @param PageContainerVersion|Container $container
     *
     * @return string
     * @throws \Exception
     */
    public function __invoke(
        string $innerHtml,
        Container $container
    ): string
    {
        $isPageContainer = $container instanceof PageContainerVersion;

        return '<div class="container-fluid rcmContainer" '
        . 'data-containerid="' . $container->getId() . '" '
        . ($isPageContainer ? 'data-ispagecontainer="Y" ' : '')
        // . 'data-container="????" '
        // . 'id="' . $container->getUid()
        . '">'
        . $innerHtml
        . '</div>';
    }
}
