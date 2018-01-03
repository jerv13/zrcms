<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;
use Zrcms\CoreView\Api\Render\GetViewLayoutTags;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewByRequestBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetViewByRequestBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetViewByRequestBasic(
            $serviceContainer->get(GetSiteCmsResource::class),
            $serviceContainer->get(GetThemeName::class),
            $serviceContainer->get(GetPageCmsResource::class),
            $serviceContainer->get(GetLayoutName::class),
            $serviceContainer->get(GetLayoutCmsResource::class),
            $serviceContainer->get(GetViewLayoutTags::class),
            $serviceContainer->get(BuildView::class)
        );
    }
}
