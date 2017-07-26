<?php

namespace Zrcms\ContentCore\Theme\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Theme\Model\Layout;
use Zrcms\ContentCore\Theme\Model\PropertiesLayout;

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
     * @var string
     */
    protected $defaultRenderDataGetterServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param string             $defaultRenderDataGetterServiceName
     */
    public function __construct(
        $serviceContainer,
        string $defaultRenderDataGetterServiceName = RenderLayoutMustache::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->defaultRenderDataGetterServiceName = $defaultRenderDataGetterServiceName;
    }

    /**
     * @param Layout|Content         $layout
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string[] ['{render-tag}' => '{html}']
     */
    public function __invoke(
        Content $layout,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $renderDataGetterServiceName = $layout->getProperty(
            PropertiesLayout::RENDER_DATA_GETTER,
            $this->defaultRenderDataGetterServiceName
        );

        /** @var GetLayoutRenderData $render */
        $renderDataGetterService = $this->serviceContainer->get(
            $renderDataGetterServiceName
        );

        if (get_class($renderDataGetterService) == get_class($this)) {
            throw new \Exception(
                'Class ' . get_class($this) . ' can not use itself as service.'
            );
        }

        return $renderDataGetterService->__invoke(
            $layout,
            $request,
            $options
        );
    }
}
