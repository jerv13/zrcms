<?php

namespace Zrcms\CoreApplication\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\CmsResourcesToArray;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Model\CmsResource;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsResourcesToArrayBasic implements CmsResourcesToArray
{
    protected $cmsResourceToArray;

    /**
     * @param CmsResourceToArray $cmsResourceToArray
     */
    public function __construct(
        CmsResourceToArray $cmsResourceToArray
    ) {
        $this->cmsResourceToArray = $cmsResourceToArray;
    }

    /**
     * @param CmsResource[] $cmsResources
     * @param array         $options
     *
     * @return array
     */
    public function __invoke(
        array $cmsResources,
        array $options = []
    ): array {
        $array = [];
        foreach ($cmsResources as $cmsResource) {
            $array[] = $this->cmsResourceToArray->__invoke(
                $cmsResource,
                Param::getArray(
                    $options,
                    self::OPTION_CMS_RESOURCE_OPTIONS,
                    []
                )
            );
        }

        return $array;
    }
}
