<?php

namespace Zrcms\CoreView\Model;

use Reliv\ArrayProperties\Property;
use Zrcms\Core\Model\ContentAbstract;
use Zrcms\Core\Model\PropertiesTrait;
use Zrcms\CorePage\Model\PageCmsResource;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreTheme\Model\LayoutCmsResource;
use Zrcms\CoreView\Fields\FieldsView;

/**
 * ViewModel
 *
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ViewAbstract extends ContentAbstract implements View
{
    use PropertiesTrait;

    /**
     * @param SiteCmsResource   $siteCmsResource
     * @param PageCmsResource   $pageCmsResource
     * @param LayoutCmsResource $layoutCmsResource
     * @param string            $strategy
     * @param array             $properties
     * @param string|null       $id
     *
     * @return View
     */
    public static function build(
        SiteCmsResource $siteCmsResource,
        PageCmsResource $pageCmsResource,
        LayoutCmsResource $layoutCmsResource,
        string $strategy,
        array $properties,
        $id = null
    ): View {
        $properties = [
            FieldsView::SITE_CMS_RESOURCE
            => $siteCmsResource,

            FieldsView::PAGE_CMS_RESOURCE
            => $pageCmsResource,

            FieldsView::LAYOUT_CMS_RESOURCE
            => $layoutCmsResource,

            FieldsView::STRATEGY
            => $strategy,
        ];

        if (empty($id)) {
            $id = $siteCmsResource->getHost() . $pageCmsResource->getPath();
        }

        return new static(
            $properties,
            $id
        );
    }

    /**
     * @param array $properties
     * @param null  $id
     *
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyException
     * @throws \Throwable
     */
    public function __construct(
        array $properties,
        $id = null
    ) {
        Property::assertHas(
            $properties,
            FieldsView::SITE_CMS_RESOURCE,
            get_class($this)
        );

        Property::assertHas(
            $properties,
            FieldsView::PAGE_CMS_RESOURCE,
            get_class($this)
        );

        Property::assertHas(
            $properties,
            FieldsView::LAYOUT_CMS_RESOURCE,
            get_class($this)
        );

        Property::assertHas(
            $properties,
            FieldsView::STRATEGY,
            get_class($this)
        );

        parent::__construct(
            $properties,
            $id
        );
    }

    /**
     * @return SiteCmsResource
     */
    public function getSiteCmsResource(): SiteCmsResource
    {
        return $this->findProperty(FieldsView::SITE_CMS_RESOURCE);
    }

    /**
     * @return PageCmsResource
     */
    public function getPageCmsResource(): PageCmsResource
    {
        return $this->findProperty(FieldsView::PAGE_CMS_RESOURCE);
    }

    /**
     * @return LayoutCmsResource
     */
    public function getLayoutCmsResource(): LayoutCmsResource
    {
        return $this->findProperty(FieldsView::LAYOUT_CMS_RESOURCE);
    }

    /**
     * @return string
     */
    public function getStrategy(): string
    {
        return $this->findProperty(FieldsView::STRATEGY);
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return View
     */
    public function withProperty(
        string $name,
        $value
    ): View {
        $properties = $this->properties;
        $properties[$name] = $value;

        return new static(
            $properties,
            $this->getId()
        );
    }
}
