<?php

namespace Zrcms\ContentCore\Block\Api\Repository;

use Zrcms\ContentCore\Block\Model\BlockVersion;
use Zrcms\ContentCore\Container\Model\Container;
use Zrcms\ContentCore\Container\Model\ContainerVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindBlockVersionsByContainer
{
    /**
     * @param Container|ContainerVersion $container
     * @param array                      $options
     *
     * @return BlockVersion[]
     */
    public function __invoke(
        Container $container,
        array $options = []
    ): array;
}
