<?php

namespace Zrcms\Core\PageView\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\PageView\Model\PageView;

/**
 *
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageViewRenderDataHeadAll implements GetPageViewRenderDataHead
{
    const NAMESPACE = 'all';

    protected $serviceContainer;

    protected $renderServiceNames
        = [
            GetPageViewRenderDataHeadMeta::NAMESPACE => GetPageViewRenderDataHeadMeta::class,
            GetPageViewRenderDataHeadTitle::NAMESPACE => GetPageViewRenderDataHeadTitle::class,
            GetPageViewRenderDataHeadLink::NAMESPACE => GetPageViewRenderDataHeadLink::class,
            GetPageViewRenderDataHeadScript::NAMESPACE => GetPageViewRenderDataHeadScript::class,
        ];

    /**
     * @param ContainerInterface $serviceContainer
     * @param array              $renderServiceNames ['{tag-property-name}' => '{GetPageViewRenderDataHeadServiceName}']
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
        $renderData = [
            GetPageViewRenderDataHead::NAMESPACE => [
                self::NAMESPACE => '',
            ]
        ];

        foreach ($this->renderServiceNames as $renderServiceName) {
            /** @var GetPageViewRenderDataHead $renderService */
            $renderService = $this->serviceContainer->get(
                $renderServiceName
            );

            $subRenderData = $renderService->__invoke(
                $pageView,
                $request,
                $options
            );

            if (array_key_exists(GetPageViewRenderDataHead::NAMESPACE, $subRenderData)) {
                $subRenderData = $subRenderData[GetPageViewRenderDataHead::NAMESPACE];
            }

            foreach ($subRenderData as $subRenderDataIn) {
                $renderData[GetPageViewRenderDataHead::NAMESPACE][self::NAMESPACE] .= $subRenderDataIn;
            }
        }

        return $renderData;
    }
}
