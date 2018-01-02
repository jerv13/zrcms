<?php

namespace Zrcms\Locale\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SetLocaleBasicFactory
{
    /**
     * @param $serviceContainer
     *
     * @return SetLocaleBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        return new SetLocaleBasic(
            $config['zrcms-locale-default']
        );
    }
}
