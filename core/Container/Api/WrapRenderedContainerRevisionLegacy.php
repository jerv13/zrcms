<?php

namespace Zrcms\Core\Block\Api;

use Zrcms\Core\Container\Api\WrapRenderedContainer;
use Zrcms\Core\Container\Model\ContainerRevision;
use Zrcms\Core\Page\Model\Page;

class WrapRenderedContainerLegacy implements WrapRenderedContainer
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
    ): string
    {
        $isPageContainer = $container instanceof Page;

        return '<div class="container-fluid rcmContainer" '
        . 'data-containerid="' . $container->getId() . '" '
        . ($isPageContainer ? 'data-ispagecontainer="Y" ' : '')
        // . 'data-containerrevision="????" '
        // . 'id="' . $container->getUid()
        . '">'
        . $innerHtml
        . '</div>';
    }
}
