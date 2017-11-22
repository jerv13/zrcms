<?php

namespace Zrcms\Content\Api\CmsResourceHistory;

use Zrcms\Content\Model\CmsResourceHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResourceHistoryToArray
{
    /**
     * @param CmsResourceHistory $cmsResourceHistory
     * @param array                     $options
     *
     * @return array
     */
    public function __invoke(
        CmsResourceHistory $cmsResourceHistory,
        array $options = []
    ): array;
}
