<?php

namespace Zrcms\ContentCore\Container\Api\Content;

use Zrcms\Content\Api\Content\FindContentVersionsBy;
use Zrcms\ContentCore\Container\Model\ContainerVersion;

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
