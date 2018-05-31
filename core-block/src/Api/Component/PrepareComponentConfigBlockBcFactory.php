<?php

namespace Zrcms\CoreBlock\Api\Component;

use Psr\Container\ContainerInterface;
use Zrcms\CoreBlock\Api\GetBlockConfigFields;
use Zrcms\CoreBlock\Api\GetBlockConfigFieldsBcSubstitution;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PrepareComponentConfigBlockBcFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return PrepareComponentConfigBlockBc
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new PrepareComponentConfigBlockBc(
            $serviceContainer->get(GetBlockConfigFields::class),
            $serviceContainer->get(GetBlockConfigFieldsBcSubstitution::class),
            $serviceContainer->get(PrepareComponentConfigBlockFieldsToDefaultConfig::class)
        );
    }
}
