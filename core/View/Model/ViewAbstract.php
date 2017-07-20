<?php

namespace Zrcms\Core\View\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\ContentAbstract;
use Zrcms\Content\Model\PropertiesTrait;

use Zrcms\Core\Page\Model\Page;
use Zrcms\Core\Page\Model\PageContainerCmsResource;
use Zrcms\Core\Page\Model\PageContainer;
use Zrcms\Core\Site\Model\SiteCmsResource;
use Zrcms\Core\Site\Model\Site;
use Zrcms\Core\Theme\Model\Layout;

use Zrcms\Core\Theme\Model\LayoutCmsResource;
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
        $this->siteCmsResource = Param::getAndRemoveRequired(
            $properties,
            PropertiesView::SITE_CMS_RESOURCE,
            new PropertyMissingException(
                'Required property (' . PropertiesView::SITE_CMS_RESOURCE . ') is missing'
            )
        );

        $this->site = Param::getAndRemoveRequired(
            $properties,
            PropertiesView::SITE,
            new PropertyMissingException(
                'Required property (' . PropertiesView::SITE . ') is missing'
            )
        );

        $this->pageContainerCmsResource = Param::getAndRemoveRequired(
            $properties,
            PropertiesView::PAGE_CONTAINER_CMS_RESOURCE,
            new PropertyMissingException(
                'Required property (' . PropertiesView::PAGE_CONTAINER_CMS_RESOURCE . ') is missing'
            )
        );

        $this->page = Param::getAndRemoveRequired(
            $properties,
            PropertiesView::PAGE,
            new PropertyMissingException(
                'Required property (' . PropertiesView::PAGE . ') is missing'
            )
        );

        $this->layoutCmsResource = Param::getAndRemoveRequired(
            $properties,
            PropertiesView::LAYOUT_CMS_RESOURCE,
            new PropertyMissingException(
                'Required property (' . PropertiesView::LAYOUT_CMS_RESOURCE . ') is missing'
            )
        );

        $this->layout = Param::getAndRemoveRequired(
            $properties,
            PropertiesView::LAYOUT,
            new PropertyMissingException(
                'Required property (' . PropertiesView::LAYOUT . ') is missing'
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
     * @return Site
     */
    public function getSite(): Site
    {
        return $this->site;
    }

    /**
     * @return PageContainerCmsResource
     */
    public function getPageContainerCmsResource(): PageContainerCmsResource
    {
        return $this->pageContainerCmsResource;
    }

    /**
     * @return Page
     */
    public function getPage(): Page
    {
        return $this->page;
    }

    /**
     * @return LayoutCmsResource
     */
    public function getLayoutCmsResource(): LayoutCmsResource
    {
        return $this->layoutCmsResource;
    }

    /**
     * @return Layout
     */
    public function getLayout(): Layout
    {
        return $this->layout;
    }
}
