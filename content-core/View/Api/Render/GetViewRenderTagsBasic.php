<?php

namespace Zrcms\ContentCore\View\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\ContentCore\ViewLayoutTags\Api\Repository\FindViewLayoutTagsGetterComponentsBy;
use Zrcms\ContentCore\ViewLayoutTags\Model\ViewLayoutTagsGetterComponent;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewRenderTagsBasic implements GetViewRenderTags
{
    /**
     * @var GetServiceFromAlias
     */
    protected $getServiceFromAlias;

    /**
     * @var string
     */
    protected $serviceAliasNamespace;

    /**
     * @var FindViewLayoutTagsGetterComponentsBy
     */
    protected $findViewLayoutTagsGetterComponentsBy;

    /**
     * @param GetServiceFromAlias                  $getServiceFromAlias
     * @param FindViewLayoutTagsGetterComponentsBy $findViewLayoutTagsGetterComponentsBy
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        FindViewLayoutTagsGetterComponentsBy $findViewLayoutTagsGetterComponentsBy
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasView::NAMESPACE_CONTENT_RENDER_TAGS_GETTER;
        $this->findViewLayoutTagsGetterComponentsBy = $findViewLayoutTagsGetterComponentsBy;
    }

    /**
     * @param View|Content           $view
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        Content $view,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        // @todo always injecting page and containers always?
        $viewLayoutTagsGetterServiceAliases = [
            GetViewRenderTagsContainers::SERVICE_ALIAS,
            GetViewRenderTagsPage::SERVICE_ALIAS,
        ];

        $viewLayoutTagsGetterComponents = $this->findViewLayoutTagsGetterComponentsBy->__invoke([]);

        /** @var ViewLayoutTagsGetterComponent $viewLayoutTagsGetterComponent */
        foreach ($viewLayoutTagsGetterComponents as $viewLayoutTagsGetterComponent) {
            $viewLayoutTagsGetterServiceAliases[] = $viewLayoutTagsGetterComponent->getViewRenderTagsGetter();
        }

        $allViewRenderData = [];

        $serviceNameChecks = [];

        // @todo Only invoke the services that have tags in the layout
        /** @var GetViewRenderTags $getViewRenderTags */
        foreach ($viewLayoutTagsGetterServiceAliases as $viewLayoutTagsGetterServiceAlias) {

            // Duplicate check
            if (in_array($viewLayoutTagsGetterServiceAlias, $serviceNameChecks)) {
                // @todo need throw if this happens
                continue;
            }
            $serviceNameChecks[] = $viewLayoutTagsGetterServiceAlias;

            /** @var GetViewRenderTags $getViewRenderTags */
            $getViewRenderTags = $this->getServiceFromAlias->__invoke(
                $this->serviceAliasNamespace,
                $viewLayoutTagsGetterServiceAlias,
                GetViewRenderTags::class,
                ''
            );

            ServiceCheck::assertNotSelfReference($this, $getViewRenderTags);

            $viewRenderData = $getViewRenderTags->__invoke(
                $view,
                $request,
                $options
            );

            $allViewRenderData = array_merge(
                $allViewRenderData,
                $viewRenderData
            );
        }


        return $allViewRenderData;
    }
}
