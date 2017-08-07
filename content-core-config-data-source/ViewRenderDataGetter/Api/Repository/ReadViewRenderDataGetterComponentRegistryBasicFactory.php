<?php

namespace Zrcms\ContentCoreConfigDataSource\ViewLayoutTags\Api\Repository;

use Psr\Container\ContainerInterface;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewLayoutTagsGetterComponentRegistryBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadViewLayoutTagsGetterComponentRegistryBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registry = $config['zrcms']['view-layout-tags-getters'];

        return new ReadViewLayoutTagsGetterComponentRegistryBasic(
            $registry,
            $serviceContainer->get(GetServiceFromAlias::class)
        );
    }
}
