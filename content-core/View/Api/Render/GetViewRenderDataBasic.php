<?php

namespace Zrcms\ContentCore\View\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\ContentCore\ViewRenderDataGetter\Api\Repository\FindViewRenderDataGetterComponentsBy;
use Zrcms\ContentCore\ViewRenderDataGetter\Model\ViewRenderDataGetterComponent;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewRenderDataBasic implements GetViewRenderData
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
     * @var FindViewRenderDataGetterComponentsBy
     */
    protected $findViewRenderDataGetterComponentsBy;

    /**
     * @param GetServiceFromAlias                  $getServiceFromAlias
     * @param FindViewRenderDataGetterComponentsBy $findViewRenderDataGetterComponentsBy
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        FindViewRenderDataGetterComponentsBy $findViewRenderDataGetterComponentsBy
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasView::NAMESPACE_CONTENT_RENDER_DATA_GETTER;
        $this->findViewRenderDataGetterComponentsBy = $findViewRenderDataGetterComponentsBy;
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
        $viewRenderDataGetterServiceAliases = [
            GetViewRenderDataContainers::SERVICE_ALIAS,
            GetViewRenderDataPage::SERVICE_ALIAS,
        ];

        $viewRenderDataGetterComponents = $this->findViewRenderDataGetterComponentsBy->__invoke([]);

        /** @var ViewRenderDataGetterComponent $viewRenderDataGetterComponent */
        foreach ($viewRenderDataGetterComponents as $viewRenderDataGetterComponent) {
            $viewRenderDataGetterServiceAliases[] = $viewRenderDataGetterComponent->getViewRenderDataGetter();
        }

        $allViewRenderData = [];

        $serviceNameChecks = [];

        // @todo Only invoke the services that have tags in the layout
        /** @var GetViewRenderData $getViewRenderData */
        foreach ($viewRenderDataGetterServiceAliases as $viewRenderDataGetterServiceAlias) {
            // Duplicate check
            if (in_array($viewRenderDataGetterServiceAlias, $serviceNameChecks)) {
                // @todo need throw if this happens
                continue;
            }
            $serviceNameChecks[] = $viewRenderDataGetterServiceAlias;

            /** @var GetViewRenderData $getViewRenderData */
            $getViewRenderData = $this->getServiceFromAlias->__invoke(
                $this->serviceAliasNamespace,
                $viewRenderDataGetterServiceAlias,
                GetViewRenderData::class,
                ''
            );

            ServiceCheck::assertNotSelfReference($this, $getViewRenderData);

            $viewRenderData = $getViewRenderData->__invoke(
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
