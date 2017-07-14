<?php

namespace Zrcms\Core\BlockInstance\Api;

use Zrcms\Core\Container\Api\WrapRenderedContainer;
use Zrcms\Core\Container\Model\Container;
use Zrcms\Core\Page\Model\Page;

class WrapRenderedContainerLegacy implements WrapRenderedContainer
{
    /**
     * @param string    $innerHtml
     * @param Container $container
     *
     * @return string
     */
    public function __invoke(string $innerHtml, Container $container): string
    {
        $isPageContainer = $container instanceof Page;

        return '<div class="container-fluid rcmContainer" '
        . 'data-containerid="' . $container->getId() . '" '
        . ($isPageContainer ? 'data-ispagecontainer="Y" ' : '')
//            . 'data-containerrevision="????" '
//            . 'id="' . $container->getUid()
        . '">'
        . $innerHtml
        . '</div>';
    }
}
