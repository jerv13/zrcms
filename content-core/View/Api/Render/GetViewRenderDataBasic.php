<?php

namespace Zrcms\ContentCore\View\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\ContentCore\View\Model\ViewComponent;
use Zrcms\ContentCoreConfigDataSource\View\Api\Repository\FindViewComponent;

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
     * @var FindViewComponent
     */
    protected $findViewComponent;

    /**
     * @param ContainerInterface $serviceContainer
     * @param FindViewComponent  $findViewComponent
     */
    public function __construct(
        $serviceContainer,
        FindViewComponent $findViewComponent
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->findViewComponent = $findViewComponent;
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
        /** @var ViewComponent $viewComponent */
        $viewComponent = $this->findViewComponent->__invoke(
            ViewComponent::DEFAULT_NAME
        );

        if (empty($viewComponent)) {
            throw new \Exception('No view component found');
        }

        $viewRenderDataGetterServiceNames = $viewComponent->getViewRenderDataGetters();
        $allViewRenderData = [];

        /** @var GetViewRenderData $getViewRenderData */
        foreach ($viewRenderDataGetterServiceNames as $viewRenderDataGetterServiceName) {
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
