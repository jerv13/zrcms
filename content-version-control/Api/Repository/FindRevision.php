<?php

namespace Zrcms\ContentVersionControl\Api\Repository;

use Zrcms\ContentVersionControl\Model\Revision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindRevision
{
    /**
     * @param string $uri
     * @param array  $options
     *
     * @return Revision|null
     */
    public function __invoke(
        string $uri,
        array $options = []
    );
}
