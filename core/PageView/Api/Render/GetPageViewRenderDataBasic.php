<?php

namespace Zrcms\Core\PageView\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\PageView\Api\Repository\FindPageViewRenderDataServices;
use Zrcms\Core\PageView\Model\PageView;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageViewRenderDataBasic implements GetPageViewRenderData
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var FindPageViewRenderDataServices
     */
    protected $findPageViewRenderDataServices;

    /**
     * @param FindPageViewRenderDataServices $findPageViewRenderDataServices
     */
    public function __construct(
        FindPageViewRenderDataServices $findPageViewRenderDataServices
    ) {
        $this->findPageViewRenderDataServices = $findPageViewRenderDataServices;
    }

    /**
     * @param PageView|Content       $pageView
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        Content $pageView,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $getPageViewRenderDataServices = $this->findPageViewRenderDataServices->__invoke([]);
        $allPageViewRenderData = [];

        /** @var GetPageViewRenderData $getPageViewRenderData */
        foreach ($getPageViewRenderDataServices as $getPageViewRenderData) {

            $pageViewRenderData = $getPageViewRenderData->__invoke(
                $pageView,
                $request,
                $options
            );

            $allPageViewRenderData = array_merge(
                $allPageViewRenderData,
                $pageViewRenderData
            );
        }

        return $allPageViewRenderData;
    }
}
