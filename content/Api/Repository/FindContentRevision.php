<?php

namespace Zrcms\Content\Api\Repository;

use Zrcms\Content\Model\ContentRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindContentRevision
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return ContentRevision|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
