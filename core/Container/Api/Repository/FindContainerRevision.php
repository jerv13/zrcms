<?php

namespace Zrcms\Core\Container\Api\Repository;

use Zrcms\Content\Api\Repository\FindContentRevision;
use Zrcms\Content\Model\ContentRevision;
use Zrcms\Core\Container\Model\ContainerRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindContainerRevision extends FindContentRevision
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return ContainerRevision|ContentRevision|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
