<?php

namespace Zrcms\CoreContainer\Api\Content;

use Zrcms\Core\Api\Content\InsertContentVersion;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreContainer\Model\ContainerVersion;

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
