<?php

namespace Zrcms\Core\Api\CmsResourceHistory;

use Zrcms\Core\Model\CmsResourceHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResourceHistoryToArray
{
    const OPTION_HIDE_PROPERTIES = 'hideProperties';

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
