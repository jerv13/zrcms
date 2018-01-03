<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;
use Zrcms\CoreTheme\Api\CmsResource\FindLayoutCmsResourceByThemeNameLayoutName;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetLayoutCmsResourceBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetLayoutCmsResourceBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetLayoutCmsResourceBasic(
            $serviceContainer->get(FindLayoutCmsResourceByThemeNameLayoutName::class)
        );
    }
}
