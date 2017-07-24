<?php

namespace Zrcms\ContentCore\View\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\View\Api\Repository\FindViewRenderDataGetters;
use Zrcms\ContentCore\View\Model\View;

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
     * @var FindViewRenderDataGetters
     */
    protected $findViewRenderDataGetters;

    /**
     * @param FindViewRenderDataGetters $findViewRenderDataGetters
     */
    public function __construct(
        FindViewRenderDataGetters $findViewRenderDataGetters
    ) {
        $this->findViewRenderDataGetters = $findViewRenderDataGetters;
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
        $viewRenderDataGetters = $this->findViewRenderDataGetters->__invoke([]);
        $allViewRenderData = [];

        /** @var GetViewRenderData $getViewRenderData */
        foreach ($viewRenderDataGetters as $getViewRenderData) {

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
