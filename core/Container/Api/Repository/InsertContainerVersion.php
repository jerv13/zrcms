<?php

namespace Zrcms\Core\Container\Api\Repository;

use Zrcms\Content\Api\Repository\InsertContentVersion;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\Core\Container\Model\ContainerVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface InsertContainerVersion extends InsertContentVersion
{
    /**
     * @param ContainerVersion|ContentVersion $containerVersion
     * @param array                           $options
     *
     * @return ContentVersion
     */
    public function __invoke(
        ContentVersion $containerVersion,
        array $options = []
    ): ContentVersion;
}
