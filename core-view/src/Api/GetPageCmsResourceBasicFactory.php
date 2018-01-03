<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourceBySitePath;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageCmsResourceBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetPageCmsResourceBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetPageCmsResourceBasic(
            $serviceContainer->get(FindPageCmsResourceBySitePath::class)
        );
    }
}
