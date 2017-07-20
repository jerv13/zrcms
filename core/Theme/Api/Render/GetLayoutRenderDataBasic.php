<?php

namespace Zrcms\Core\Theme\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\Theme\Model\Layout;
use Zrcms\Core\Theme\Model\PropertiesLayout;

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
     * @return array ['templateTag' => '{html}']
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

        return $renderDataGetterService->__invoke(
            $layout,
            $request,
            $options
        );
    }
}
