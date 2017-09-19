<?php

namespace Zrcms\ContentCore\View\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\ContentAbstract;
use Zrcms\Content\Model\PropertiesTrait;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;
use Zrcms\ContentCore\View\Fields\FieldsView;
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

    protected $pageContainerCmsResource;

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
            PropertyMissingException::buildThrower(
                FieldsView::SITE_CMS_RESOURCE,
                $properties,
                get_class($this)
            )
        );

        $this->pageContainerCmsResource = Param::getRequired(
            $properties,
            FieldsView::PAGE_CONTAINER_CMS_RESOURCE,
            PropertyMissingException::buildThrower(
                FieldsView::PAGE_CONTAINER_CMS_RESOURCE,
                $properties,
                get_class($this)
            )
        );

        $this->layoutCmsResource = Param::getRequired(
            $properties,
            FieldsView::LAYOUT_CMS_RESOURCE,
            PropertyMissingException::buildThrower(
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
     * @return PageContainerCmsResource
     */
    public function getPageContainerCmsResource(): PageContainerCmsResource
    {
        return $this->pageContainerCmsResource;
    }

    /**
     * @return LayoutCmsResource
     */
    public function getLayoutCmsResource(): LayoutCmsResource
    {
        return $this->layoutCmsResource;
    }
}
