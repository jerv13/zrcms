<?php

namespace Zrcms\Core\BlockInstance\Api;

use Zrcms\Core\Block\Api\FindBlock;
use Zrcms\Core\Block\Model\BlockProperties;
use Zrcms\Core\BlockInstance\Model\BlockInstance;
use Zrcms\Core\BlockInstance\Model\BlockInstanceProperties;
use Zrcms\Core\Container\Api\WrapRenderedContainer;
use Zrcms\Core\Container\Model\Container;
use Zrcms\Core\Page\Model\Page;

class WrapRenderedContainerLegacy implements WrapRenderedContainer
{
    public function __invoke(string $innerHtml, Container $container): string
    {
        $isPageContainer = $container instanceof Page;

        return '<div class="container-fluid rcmContainer" '
            . 'data-containerid="' . $container->getUid() . '" '
            . ($isPageContainer ? 'data-ispagecontainer="Y" ' : '')
//            . 'data-containerrevision="????" '
//            . 'id="' . $container->getUid()
            . '">'
            . $containerInnerHtml
            . '</div>';
    }
}
