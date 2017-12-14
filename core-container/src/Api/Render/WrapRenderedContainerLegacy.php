<?php

namespace Zrcms\CoreContainer\Api\Render;

use Zrcms\CoreContainer\Model\Container;
use Zrcms\CorePage\Model\PageVersion;

class WrapRenderedContainerLegacy implements WrapRenderedContainer
{
    /**
     * @param string                $innerHtml
     * @param PageVersion|Container $container
     *
     * @return string
     * @throws \Exception
     */
    public function __invoke(
        string $innerHtml,
        Container $container
    ): string {
        $isPage = $container instanceof PageVersion;

        // @todo REMOVE class: rcmContainer
        return "\n"
        . '<div class="content-container container-fluid rcmContainer"'
        . ' container-version-id="' . $container->getId() . '"'
        . ($isPage ? ' is-page-container="true"' : '')
        . ' data-container-version-id="' . $container->getId() . '"'
//        . ' data-containerid="' . $container->getId() . '" ' //WARNING THIS MAY NOT BE WHAT RCM ADMIN EXPECTS
        . ($isPage ? ' data-ispage="Y"' : '')
        // . ' data-container="????" '
        // . ' id="' . $container->getUid()
        . ">\n"
        . $innerHtml
        . "\n</div>\n";
    }
}
