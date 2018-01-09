<?php

namespace Zrcms\CoreView\Api;

use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\CoreApplication\Api\ArrayFromGetters;
use Zrcms\CoreView\Model\View;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ViewToArrayBasic implements ViewToArray
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
     * @param View  $view
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        View $view,
        array $options = []
    ): array {
        $hideProperties = Param::getArray(
            $options,
            self::OPTION_HIDE_PROPERTIES,
            []
        );

        $array = ArrayFromGetters::invoke(
            $view,
            $hideProperties
        );

        $array['siteCmsResource'] = $this->cmsResourceToArray->__invoke(
            $view->getSiteCmsResource()
        );

        $array['pageCmsResource'] = $this->cmsResourceToArray->__invoke(
            $view->getPageCmsResource()
        );

        $array['layoutCmsResource'] = $this->cmsResourceToArray->__invoke(
            $view->getLayoutCmsResource()
        );

        return $array;
    }
}
