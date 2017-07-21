<?php

namespace Zrcms\Core\Block\Api\Repository;

use Zrcms\Core\Block\Model\BlockVersion;
use Zrcms\Core\Container\Model\ContainerVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindBlockVersionByContainerVersion
{
    /**
     * @param ContainerVersion $containerVersion
     * @param array            $options
     *
     * @return BlockVersion|null
     */
    public function __invoke(
        ContainerVersion $containerVersion,
        array $options = []
    );
}
