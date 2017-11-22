<?php

namespace Zrcms\ContentCore\Container\Api\Content;

use Zrcms\Content\Api\Content\InsertContentVersion;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Container\Model\ContainerVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface InsertContainerVersion extends InsertContentVersion
{
    /**
     * @param ContainerVersion|ContentVersion $containerVersion
     * @param array                           $options
     *
     * @return ContainerVersion|ContentVersion
     */
    public function __invoke(
        ContentVersion $containerVersion,
        array $options = []
    ): ContentVersion;
}