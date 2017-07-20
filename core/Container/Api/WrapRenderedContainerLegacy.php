<?php

namespace Zrcms\Core\Block\Api;

use Zrcms\Core\Container\Api\WrapRenderedContainer;
use Zrcms\Core\Container\Model\Container;
use Zrcms\Core\Container\Model\ContainerVersion;
use Zrcms\Core\Page\Model\PageContainerVersion;

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
