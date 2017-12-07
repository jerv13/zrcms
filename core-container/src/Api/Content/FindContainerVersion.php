<?php

namespace Zrcms\CoreContainer\Api\Content;

use Zrcms\Core\Api\Content\FindContentVersion;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreContainer\Model\ContainerVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindContainerVersion extends FindContentVersion
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return ContainerVersion|ContentVersion|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
