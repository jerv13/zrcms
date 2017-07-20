<?php

namespace Zrcms\Core\View\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\View\Api\Repository\FindViewRenderDataServices;
use Zrcms\Core\View\Model\View;

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
     * @var FindViewRenderDataServices
     */
    protected $findViewRenderDataServices;

    /**
     * @param FindViewRenderDataServices $findViewRenderDataServices
     */
    public function __construct(
        FindViewRenderDataServices $findViewRenderDataServices
    ) {
        $this->findViewRenderDataServices = $findViewRenderDataServices;
    }

    /**
     * @param View|Content       $view
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
        $getViewRenderDataServices = $this->findViewRenderDataServices->__invoke([]);
        $allViewRenderData = [];

        /** @var GetViewRenderData $getViewRenderData */
        foreach ($getViewRenderDataServices as $getViewRenderData) {

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
