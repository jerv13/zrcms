<?php

namespace Zrcms\CoreApplication\Api\CmsResourceHistory;

use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoryToArray;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Core\Model\CmsResourceHistory;
use Zrcms\CoreApplication\Api\ArrayFromGetters;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsResourceHistoryToArrayBasic implements CmsResourceHistoryToArray
{
    /**
     * @var ContentVersionToArray
     */
    protected $contentVersionToArray;

    /**
     * @var CmsResourceToArray
     */
    protected $cmsResourceToArray;

    /**
     * @param ContentVersionToArray $contentVersionToArray
     * @param CmsResourceToArray    $cmsResourceToArray
     */
    public function __construct(
        ContentVersionToArray $contentVersionToArray,
        CmsResourceToArray $cmsResourceToArray
    ) {
        $this->contentVersionToArray = $contentVersionToArray;
        $this->cmsResourceToArray = $cmsResourceToArray;
    }

    /**
     * @param CmsResourceHistory $cmsResourceHistory
     * @param array              $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        CmsResourceHistory $cmsResourceHistory,
        array $options = []
    ): array {
        $hideProperties = Param::getArray(
            $options,
            self::OPTION_HIDE_PROPERTIES,
            []
        );

        $array = ArrayFromGetters::invoke(
            $cmsResourceHistory,
            $hideProperties
        );

        $array['contentVersion'] = $this->contentVersionToArray->__invoke(
            $cmsResourceHistory->getContentVersion()
        );

        $array['cmsResource'] = $this->cmsResourceToArray->__invoke(
            $cmsResourceHistory->getCmsResource()
        );

        return $array;
    }
}
