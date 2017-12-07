<?php

namespace Zrcms\CoreContainer\Api\Content;

use Zrcms\Core\Api\Content\FindContentVersionsBy;
use Zrcms\CoreContainer\Model\ContainerVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindContainerVersionsBy extends FindContentVersionsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return ContainerVersion[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
