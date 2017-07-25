<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api\Repository;

use Zrcms\Content\Api\Repository\FindContentVersion;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Theme\Model\Layout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLayoutVersion extends FindContentVersion
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return Layout|Content|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
