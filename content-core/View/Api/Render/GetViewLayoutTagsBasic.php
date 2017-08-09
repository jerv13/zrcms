<?php

namespace Zrcms\ContentCore\View\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\View\Api\Repository\FindViewLayoutTagsComponentsBy;
use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\ContentCore\View\Model\ViewLayoutTagsComponent;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTagsBasic implements GetViewLayoutTags
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
     * @var FindViewLayoutTagsComponentsBy
     */
    protected $findViewLayoutTagsComponentsBy;

    /**
     * @param GetServiceFromAlias            $getServiceFromAlias
     * @param FindViewLayoutTagsComponentsBy $findViewLayoutTagsComponentsBy
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        FindViewLayoutTagsComponentsBy $findViewLayoutTagsComponentsBy
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasView::NAMESPACE_COMPONENT_VIEW_LAYOUT_TAGS_GETTER;
        $this->findViewLayoutTagsComponentsBy = $findViewLayoutTagsComponentsBy;
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
            GetViewLayoutTagsContainers::RENDER_TAG_CONTAINER => GetViewLayoutTagsContainers::SERVICE_ALIAS,
            GetViewLayoutTagsPage::RENDER_TAG_PAGE => GetViewLayoutTagsPage::SERVICE_ALIAS,
        ];

        // @todo only get layout components that have paths in the layout
        $viewLayoutTagsComponents = $this->findViewLayoutTagsComponentsBy->__invoke([]);

        /** @var ViewLayoutTagsComponent $viewLayoutTagsComponent */
        foreach ($viewLayoutTagsComponents as $viewLayoutTagsComponent) {
            $viewLayoutTagsGetterServiceAliases[$viewLayoutTagsComponent->getName()]
                = $viewLayoutTagsComponent->getViewLayoutTagsGetter();
        }

        $allViewRenderTags = [];

        $serviceNameChecks = [];

        // @todo Only invoke the services that have tags in the layout
        /** @var GetViewLayoutTags $getViewLayoutTags */
        foreach ($viewLayoutTagsGetterServiceAliases as $name => $viewLayoutTagsGetterServiceAlias) {

            // Duplicate check
            if (in_array($viewLayoutTagsGetterServiceAlias, $serviceNameChecks)) {
                // @todo need throw if this happens
                continue;
            }

            $serviceNameChecks[] = $viewLayoutTagsGetterServiceAlias;

            /** @var GetViewLayoutTags $getViewLayoutTags */
            $getViewLayoutTags = $this->getServiceFromAlias->__invoke(
                $this->serviceAliasNamespace,
                $viewLayoutTagsGetterServiceAlias,
                GetViewLayoutTags::class,
                ''
            );

            ServiceCheck::assertNotSelfReference($this, $getViewLayoutTags);

            $viewRenderTags = $getViewLayoutTags->__invoke(
                $view,
                $request,
                $options
            );

            $allViewRenderTags = array_merge(
                $allViewRenderTags,
                $viewRenderTags
            );
        }

        return $allViewRenderTags;
    }
}
