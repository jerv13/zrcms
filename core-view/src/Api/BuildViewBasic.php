<?php

namespace Zrcms\CoreView\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CorePage\Model\PageCmsResource;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreTheme\Model\LayoutCmsResource;
use Zrcms\CoreView\Fields\FieldsView;
use Zrcms\CoreView\Model\View;
use Zrcms\CoreView\Model\ViewBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildViewBasic implements BuildView
{
    protected $mutateView;

    /**
     * @param MutateView $mutateView
     */
    public function __construct(
        MutateView $mutateView
    ) {
        $this->mutateView = $mutateView;
    }

    /**
     * @param ServerRequestInterface $request
     * @param SiteCmsResource        $siteCmsResource
     * @param PageCmsResource        $pageCmsResource
     * @param LayoutCmsResource      $layoutCmsResource
     * @param array                  $properties
     *
     * @return View
     */
    public function __invoke(
        ServerRequestInterface $request,
        SiteCmsResource $siteCmsResource,
        PageCmsResource $pageCmsResource,
        LayoutCmsResource $layoutCmsResource,
        array $properties = []
    ): View {
        $properties = [
            FieldsView::SITE_CMS_RESOURCE
            => $siteCmsResource,

            FieldsView::PAGE_CMS_RESOURCE
            => $pageCmsResource,

            FieldsView::LAYOUT_CMS_RESOURCE
            => $layoutCmsResource,
        ];

        $view = new ViewBasic(
            $properties,
            $siteCmsResource->getHost() . $pageCmsResource->getPath()
        );

        return $this->mutateView->__invoke(
            $request,
            $view
        );
    }
}
