<?php

namespace Zrcms\CoreView\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\Core\Fields\FieldsComponentConfig;
use Zrcms\Core\Model\Content;
use Zrcms\CoreView\Model\ServiceAliasView;
use Zrcms\CoreView\Model\View;
use Zrcms\CoreView\Model\ViewLayoutTagsComponent;
use Zrcms\ServiceAlias\Api\AssertNotSelfReference;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTagsBasic implements GetViewLayoutTags
{
    protected $getServiceFromAlias;
    protected $serviceAliasNamespace;
    protected $findComponentsBy;

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param FindComponentsBy    $findComponentsBy
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        FindComponentsBy $findComponentsBy
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasView::ZRCMS_COMPONENT_VIEW_LAYOUT_TAGS_GETTER;
        $this->findComponentsBy = $findComponentsBy;
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
    ): array {
        // @todo always injecting page and containers always?
        $viewLayoutTagsGetterServiceAliases = [
            GetViewLayoutTagsContainers::RENDER_TAG_CONTAINER => GetViewLayoutTagsContainers::SERVICE_ALIAS,
            GetViewLayoutTagsPage::RENDER_TAG_PAGE => GetViewLayoutTagsPage::SERVICE_ALIAS,
        ];

        // @todo only get layout components that have paths in the layout
        $viewLayoutTagsComponents = $this->findComponentsBy->__invoke(
            [FieldsComponentConfig::TYPE => 'view-layout-tag']
        );

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

            AssertNotSelfReference::invoke($this, $getViewLayoutTags);

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
