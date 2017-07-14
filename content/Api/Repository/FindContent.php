<?php

namespace Zrcms\Content\Api\Repository;

use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindContent
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return Content|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
