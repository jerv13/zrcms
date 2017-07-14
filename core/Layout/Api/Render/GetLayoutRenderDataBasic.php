<?php

namespace Zrcms\Core\Layout\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\Layout\Api\Repository\FindLayoutRenderDataServices;
use Zrcms\Core\Layout\Model\Layout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetLayoutRenderDataBasic implements GetLayoutRenderData
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var FindLayoutRenderDataServices
     */
    protected $findLayoutRenderDataServices;

    /**
     * @var string
     */
    protected $defaultRenderServiceName;

    /**
     * @param FindLayoutRenderDataServices $findLayoutRenderDataServices
     * @param string                       $defaultRenderServiceName
     */
    public function __construct(
        FindLayoutRenderDataServices $findLayoutRenderDataServices,
        string $defaultRenderServiceName = RenderLayoutMustache::class
    ) {
        $this->findLayoutRenderDataServices = $findLayoutRenderDataServices;
        $this->defaultRenderServiceName = $defaultRenderServiceName;
    }

    /**
     * @param Layout|Content         $layout
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        Content $layout,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $getLayoutRenderDataServices = $this->findLayoutRenderDataServices->__invoke([]);
        $allLayoutRenderData = [];

        /** @var GetLayoutRenderData $getLayoutRenderData */
        foreach ($getLayoutRenderDataServices as $getLayoutRenderData) {

            $layoutRenderData = $getLayoutRenderData->__invoke(
                $layout,
                $request,
                $options
            );

            $allLayoutRenderData = array_merge(
                $allLayoutRenderData,
                $layoutRenderData
            );
        }

        return $allLayoutRenderData;
    }
}
