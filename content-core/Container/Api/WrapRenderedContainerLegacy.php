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

        return "\n<div class=\"container-fluid rcmContainer\""
        . ' data-container-version-id="' . $container->getId() . '" '
//        . ' data-containerid="' . $container->getId() . '" ' //WARNING THIS MAY NOT BE WHAT RCM ADMIN EXPECTS
        . ($isPageContainer ? ' data-ispagecontainer="Y"' : '')
        // . 'data-container="????" '
        // . 'id="' . $container->getUid()
        . ">\n"
        . $innerHtml
        . "\n</div>\n";
    }
}
