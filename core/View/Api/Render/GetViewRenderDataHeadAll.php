<?php

namespace Zrcms\Core\View\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\View\Model\View;

/**
 *
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewRenderDataHeadAll implements GetViewRenderDataHead
{
    const NAMESPACE = 'all';

    protected $serviceContainer;

    protected $renderServiceNames
        = [
            GetViewRenderDataHeadMeta::NAMESPACE => GetViewRenderDataHeadMeta::class,
            GetViewRenderDataHeadTitle::NAMESPACE => GetViewRenderDataHeadTitle::class,
            GetViewRenderDataHeadLink::NAMESPACE => GetViewRenderDataHeadLink::class,
            GetViewRenderDataHeadScript::NAMESPACE => GetViewRenderDataHeadScript::class,
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
        $renderData = [
            GetViewRenderDataHead::NAMESPACE => [
                self::NAMESPACE => '',
            ]
        ];

        foreach ($this->renderServiceNames as $renderServiceName) {
            /** @var GetViewRenderDataHead $renderService */
            $renderService = $this->serviceContainer->get(
                $renderServiceName
            );

            $subRenderData = $renderService->__invoke(
                $view,
                $request,
                $options
            );

            if (array_key_exists(GetViewRenderDataHead::NAMESPACE, $subRenderData)) {
                $subRenderData = $subRenderData[GetViewRenderDataHead::NAMESPACE];
            }

            foreach ($subRenderData as $subRenderDataIn) {
                $renderData[GetViewRenderDataHead::NAMESPACE][self::NAMESPACE] .= $subRenderDataIn;
            }
        }

        return $renderData;
    }
}
