<?php

namespace Zrcms\Content\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetTypeValueBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetTypeValueBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $typesConfig = $config['zrcms-types'];

        return new GetTypeValueBasic(
            $typesConfig
        );
    }
}
