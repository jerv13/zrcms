<?php

namespace Zrcms\ContentCore\Block\Api\Repository;

use Zrcms\ContentCore\Block\Model\BlockVersion;
use Zrcms\ContentCore\Container\Model\ContainerVersion;

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
