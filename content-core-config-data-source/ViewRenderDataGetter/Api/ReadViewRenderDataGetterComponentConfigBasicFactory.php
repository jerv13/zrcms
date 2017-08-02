<?php

namespace Zrcms\ContentCoreConfigDataSource\ViewRenderDataGetter\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewRenderDataGetterComponentConfigBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadViewRenderDataGetterComponentConfigBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new ReadViewRenderDataGetterComponentConfigBasic(
            $serviceContainer
        );
    }
}
