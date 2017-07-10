<?php

namespace Zrcms\Core\Page\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindPagePublishedBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null|int   $limit
     * @param null|int   $offset
     * @param array      $options
     *
     * @return array [PagePublished]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    );
}
