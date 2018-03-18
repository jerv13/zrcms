<?php

namespace Zrcms\CoreView\Api;

use Reliv\ArrayProperties\Property;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\CoreView\Fields\FieldsView;
use Zrcms\CoreView\Model\View;

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

        $properties[FieldsView::SITE_CONTAINER_CMS_RESOURCES] = [];

        foreach ($view->getSiteContainerCmsResources() as $siteContainerCmsResource) {
            $properties[FieldsView::SITE_CONTAINER_CMS_RESOURCES][] = $this->cmsResourceToArray->__invoke(
                $siteContainerCmsResource
            );
        }

        $array['properties'] = $properties;

        return $array;
    }
}
