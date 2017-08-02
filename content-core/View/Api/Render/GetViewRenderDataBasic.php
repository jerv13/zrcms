<?php

namespace Zrcms\ContentCore\View\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\ContentCore\ViewRenderDataGetter\Api\Repository\FindViewRenderDataGetterComponentsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewRenderDataBasic implements GetViewRenderData
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var FindViewRenderDataGetterComponentsBy
     */
    protected $findViewRenderDataGetterComponentsBy;

    /**
     * @param ContainerInterface                   $serviceContainer
     * @param FindViewRenderDataGetterComponentsBy $findViewRenderDataGetterComponentsBy
     */
    public function __construct(
        $serviceContainer,
        FindViewRenderDataGetterComponentsBy $findViewRenderDataGetterComponentsBy
    ) {
        $this->serviceContainer = $serviceContainer;
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
        $viewRenderDataGetterServiceNames = $this->findViewRenderDataGetterComponentsBy->__invoke([]);

        // @todo always injecting page and containers - should we do this?
        $viewRenderDataGetterServiceNames[] = GetViewRenderDataContainers::class;
        $viewRenderDataGetterServiceNames[] = GetViewRenderDataPage::class;

        $allViewRenderData = [];

        $serviceNameChecks = [];

        // @todo Only invoke the services that have tags in the layout
        /** @var GetViewRenderData $getViewRenderData */
        foreach ($viewRenderDataGetterServiceNames as $viewRenderDataGetterServiceName) {
            // Duplicate check
            if (in_array($viewRenderDataGetterServiceName, $serviceNameChecks)) {
                // @todo need throw if this happens
                continue;
            }
            $serviceNameChecks[] = $viewRenderDataGetterServiceName;

            /** @var GetViewRenderData $getViewRenderData */
            $getViewRenderData = $this->serviceContainer->get($viewRenderDataGetterServiceName);

            if (get_class($getViewRenderData) == get_class($this)) {
                throw new \Exception(
                    'Class ' . get_class($this) . ' can not use itself as service.'
                );
            }

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
