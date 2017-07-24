<?php

namespace Zrcms\ContentCore\Container\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\Content\Api\Render\RenderContent;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Container\Model\Container;
use Zrcms\ContentCore\Container\Model\PropertiesContainer;

class RenderContainerBasic implements RenderContent
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var string
     */
    protected $defaultRenderContainerServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param string             $defaultRenderContainerServiceName
     */
    public function __construct(
        $serviceContainer,
        string $defaultRenderContainerServiceName = RenderContainerRows::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->defaultRenderContainerServiceName = $defaultRenderContainerServiceName;
    }

    /**
     * @param Container|Content $Container
     * @param array             $renderData ['render-tag' => '{html}']
     * @param array             $options
     *
     * @return string
     */
    public function __invoke(
        Content $Container,
        array $renderData,
        array $options = []
    ): string
    {
        // Get version renderer or use default
        $renderContainerServiceName = $Container->getProperty(
            PropertiesContainer::RENDERER,
            $this->defaultRenderContainerServiceName
        );

        /** @var RenderContainer $renderContainerService */
        $renderContainerService = $this->serviceContainer->get(
            $renderContainerServiceName
        );

        return $renderContainerService->__invoke(
            $Container,
            $renderData
        );
    }
}
