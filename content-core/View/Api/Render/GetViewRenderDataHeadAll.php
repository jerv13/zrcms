<?php

namespace Zrcms\ContentCore\View\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\View\Model\View;

/**
 *
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewRenderDataHeadAll implements GetViewRenderDataHead
{
    const RENDER_TAG = 'all';

    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var array
     */
    protected $renderServiceNames
        = [
            GetViewRenderDataHeadMeta::RENDER_TAG => GetViewRenderDataHeadMeta::class,
            GetViewRenderDataHeadTitle::RENDER_TAG => GetViewRenderDataHeadTitle::class,
            GetViewRenderDataHeadLink::RENDER_TAG => GetViewRenderDataHeadLink::class,
            GetViewRenderDataHeadScript::RENDER_TAG => GetViewRenderDataHeadScript::class,
        ];

    /**
     * @param ContainerInterface $serviceContainer
     * @param array              $renderServiceNames ['{tag-property-name}' => '{GetViewRenderDataHeadServiceName}']
     */
    public function __construct(
        $serviceContainer,
        array $renderServiceNames = []
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->renderServiceNames = array_merge(
            $this->renderServiceNames,
            $renderServiceNames
        );
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
        $renderData = [];

        foreach ($this->renderServiceNames as $renderTag => $renderServiceName) {
            /** @var GetViewRenderDataHead $renderService */
            $renderService = $this->serviceContainer->get(
                $renderServiceName
            );

            $subRenderData = $renderService->__invoke(
                $view,
                $request,
                $options
            );

            foreach ($subRenderData as $subRenderDataIn) {
                $renderData .= $subRenderDataIn;
            }
        }

        return [
            GetViewRenderDataHead::RENDER_TAG => [
                self::RENDER_TAG => $renderData
            ],
        ];
    }
}
