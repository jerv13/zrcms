<?php

namespace Zrcms\CoreView\Model;

use Zrcms\Core\Exception\PropertyMissing;
use Zrcms\Core\Model\ContentAbstract;
use Zrcms\Core\Model\PropertiesTrait;
use Zrcms\CorePage\Model\PageCmsResource;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreTheme\Model\LayoutCmsResource;
use Zrcms\CoreView\Fields\FieldsView;
use Zrcms\Param\Param;

/**
 * ViewModel
 *
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ViewAbstract extends ContentAbstract implements View
{
    use PropertiesTrait;

    protected $siteCmsResource;

    protected $site;

    protected $pageCmsResource;

    protected $page;

    protected $layoutCmsResource;

    protected $layout;

    /**
     * @param array $properties
     */
    public function __construct(
        array $properties
    ) {

        $this->siteCmsResource = Param::getRequired(
            $properties,
            FieldsView::SITE_CMS_RESOURCE,
            PropertyMissing::buildThrower(
                FieldsView::SITE_CMS_RESOURCE,
                $properties,
                get_class($this)
            )
        );

        $this->pageCmsResource = Param::getRequired(
            $properties,
            FieldsView::PAGE_CONTAINER_CMS_RESOURCE,
            PropertyMissing::buildThrower(
                FieldsView::PAGE_CONTAINER_CMS_RESOURCE,
                $properties,
                get_class($this)
            )
        );

        $this->layoutCmsResource = Param::getRequired(
            $properties,
            FieldsView::LAYOUT_CMS_RESOURCE,
            PropertyMissing::buildThrower(
                FieldsView::LAYOUT_CMS_RESOURCE,
                $properties,
                get_class($this)
            )
        );

        parent::__construct(
            $properties
        );
    }

    /**
     * @return SiteCmsResource
     */
    public function getSiteCmsResource(): SiteCmsResource
    {
        return $this->siteCmsResource;
    }

    /**
     * @return PageCmsResource
     */
    public function getPageCmsResource(): PageCmsResource
    {
        return $this->pageCmsResource;
    }

    /**
     * @return LayoutCmsResource
     */
    public function getLayoutCmsResource(): LayoutCmsResource
    {
        return $this->layoutCmsResource;
    }
}
