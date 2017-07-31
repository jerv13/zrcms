<?php

namespace Zrcms\Content\Api;

use Zrcms\Content\Model\CmsResourcePublishHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CsmResourcePublishHistoryToArray
{
    /**
     * @param CmsResourcePublishHistory $cmsResourcePublishHistory
     * @param array                     $options
     *
     * @return array
     */
    public function __invoke(
        CmsResourcePublishHistory $cmsResourcePublishHistory,
        array $options = []
    ): array;
}
