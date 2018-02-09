<?php

namespace Zrcms\CoreApplication\Api\CmsResourceHistory;

use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoriesToArray;
use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoryToArray;
use Zrcms\Core\Model\CmsResourceHistory;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsResourceHistoriesToArrayBasic implements CmsResourceHistoriesToArray
{
    protected $cmsResourceHistoryToArray;

    /**
     * @param CmsResourceHistoryToArray $cmsResourceHistoryToArray
     */
    public function __construct(
        CmsResourceHistoryToArray $cmsResourceHistoryToArray
    ) {
        $this->cmsResourceHistoryToArray = $cmsResourceHistoryToArray;
    }


    /**
     * @param CmsResourceHistory[] $cmsResourceHistories
     * @param array                $options
     *
     * @return array
     */
    public function __invoke(
        array $cmsResourceHistories,
        array $options = []
    ): array {
        $array = [];
        foreach ($cmsResourceHistories as $cmsResourceHistory) {
            $array[] = $this->cmsResourceHistoryToArray->__invoke(
                $cmsResourceHistory,
                Property::getArray(
                    $options,
                    self::OPTION_CMS_RESOURCE_HISTORY_OPTIONS,
                    []
                )
            );
        }

        return $array;
    }
}
