<?php

namespace Zrcms\CoreView\Api;

use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\CoreView\Fields\FieldsView;
use Zrcms\CoreView\Model\View;
use Reliv\ArrayProperties\Property;

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
        $hideProperties = Property::getArray(
            $options,
            self::OPTION_HIDE_PROPERTIES,
            []
        );

        $array = [];

        $array['id'] = $view->getId();

        $properties = $view->getProperties();

        $properties[FieldsView::SITE_CMS_RESOURCE] = $this->cmsResourceToArray->__invoke(
            $view->getSiteCmsResource()
        );

        $properties[FieldsView::PAGE_CMS_RESOURCE] = $this->cmsResourceToArray->__invoke(
            $view->getPageCmsResource()
        );

        $properties[FieldsView::LAYOUT_CMS_RESOURCE] = $this->cmsResourceToArray->__invoke(
            $view->getLayoutCmsResource()
        );

        $array['properties'] = $properties;

        return $array;
    }
}
