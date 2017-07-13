<?php

namespace Zrcms\Core\Layout\Api\Repository;

use Zrcms\ContentVersionControl\Api\Repository\FindContent;
use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\Core\Layout\Model\Layout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLayout extends FindContent
{
    /**
     * @param string $uri
     * @param array  $options
     *
     * @return Layout|Content|null
     */
    public function __invoke(
        string $uri,
        array $options = []
    );
}
