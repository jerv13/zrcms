<?php

namespace Zrcms\ContentCore\View\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\ContentAbstract;
use Zrcms\Content\Model\PropertiesTrait;

use Zrcms\ContentCore\Page\Model\Page;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCore\Site\Model\Site;
use Zrcms\ContentCore\Theme\Model\Layout;

use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;
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
            PropertiesView::SITE_CMS_RESOURCE,
            new PropertyMissingException(
                'Required property (' . PropertiesView::SITE_CMS_RESOURCE . ') is missing in: ' . get_class($this)
            )
        );

        $this->site = Param::getRequired(
            $properties,
            PropertiesView::SITE,
            new PropertyMissingException(
                'Required property (' . PropertiesView::SITE . ') is missing in: ' . get_class($this)
            )
        );

        $this->pageContainerCmsResource = Param::getRequired(
            $properties,
            PropertiesView::PAGE_CONTAINER_CMS_RESOURCE,
            new PropertyMissingException(
                'Required property (' . PropertiesView::PAGE_CONTAINER_CMS_RESOURCE . ') is missing in: ' . get_class($this)
            )
        );

        $this->page = Param::getRequired(
            $properties,
            PropertiesView::PAGE,
            new PropertyMissingException(
                'Required property (' . PropertiesView::PAGE . ') is missing in: ' . get_class($this)
            )
        );

        $this->layoutCmsResource = Param::getRequired(
            $properties,
            PropertiesView::LAYOUT_CMS_RESOURCE,
            new PropertyMissingException(
                'Required property (' . PropertiesView::LAYOUT_CMS_RESOURCE . ') is missing in: ' . get_class($this)
            )
        );

        $this->layout = Param::getRequired(
            $properties,
            PropertiesView::LAYOUT,
            new PropertyMissingException(
                'Required property (' . PropertiesView::LAYOUT . ') is missing in: ' . get_class($this)
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
