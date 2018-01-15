<?php

namespace Zrcms\Core\Api\CmsResourceHistory;

use Zrcms\Core\Model\CmsResourceHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResourceHistoriesToArray
{
    const OPTION_CMS_RESOURCE_HISTORY_OPTIONS = 'cms-resource-history-options';
    const OPTION_HIDE_PROPERTIES = 'hideProperties';

    /**
     * @param CmsResourceHistory[] $cmsResourceHistories
     * @param array                $options
     *
     * @return array
     */
    public function __invoke(
        array $cmsResourceHistories,
        array $options = []
    ): array;
}
