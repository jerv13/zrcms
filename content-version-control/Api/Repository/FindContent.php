<?php

namespace Zrcms\ContentVersionControl\Api\Repository;

use Zrcms\ContentVersionControl\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindContent
{
    /**
     * @param string $uri
     * @param array  $options
     *
     * @return Content|null
     */
    public function __invoke(
        string $uri,
        array $options = []
    );
}
