<?php

namespace Zrcms\ContentCore\Page\Api\Render;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageContainerRenderDataHtmlFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetPageContainerRenderDataHtml
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new GetPageContainerRenderDataHtml(
            $serviceContainer
        );
    }
}
