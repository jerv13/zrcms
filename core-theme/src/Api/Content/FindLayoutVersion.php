<?php

namespace Zrcms\CoreTheme\Api\Content;

use Zrcms\Core\Api\Content\FindContentVersion;
use Zrcms\Core\Model\Content;
use Zrcms\CoreTheme\Model\Layout;

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
