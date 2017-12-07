<?php

namespace Zrcms\CorePage\Api\Content;

use Zrcms\Core\Api\Content\FindContentVersionsBy;
use Zrcms\CorePage\Model\PageVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindPageVersionsBy extends FindContentVersionsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return PageVersion[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
