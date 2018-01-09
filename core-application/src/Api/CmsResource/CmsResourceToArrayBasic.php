<?php

namespace Zrcms\CoreApplication\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplication\Api\ArrayFromGetters;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsResourceToArrayBasic implements CmsResourceToArray
{
    const OPTION_HIDE_PROPERTIES = 'hideProperties';

    /**
     * @var ContentVersionToArray
     */
    protected $contentVersionToArray;

    /**
     * @param ContentVersionToArray $contentVersionToArray
     */
    public function __construct(
        ContentVersionToArray $contentVersionToArray
    ) {
        $this->contentVersionToArray = $contentVersionToArray;
    }

    /**
     * @param CmsResource $cmsResource
     * @param array       $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        CmsResource $cmsResource,
        array $options = []
    ): array {
        $hideProperties = Param::getArray(
            $options,
            self::OPTION_HIDE_PROPERTIES,
            []
        );

        $array = ArrayFromGetters::invoke(
            $cmsResource,
            $hideProperties
        );

        $array['contentVersion'] =  $this->contentVersionToArray->__invoke(
            $cmsResource->getContentVersion()
        );

        return $array;
    }
}
