<?php

namespace Zrcms\Core\Theme\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\Theme\Model\Layout;
use Zrcms\Core\Theme\Model\PropertiesLayout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderLayoutBasic implements RenderLayout
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var string
     */
    protected $defaultRenderServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param string             $defaultRenderServiceName
     */
    public function __construct(
        $serviceContainer,
        string $defaultRenderServiceName = RenderLayoutMustache::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->defaultRenderServiceName = $defaultRenderServiceName;
    }

    /**
     * @param Layout|Content $layout
     * @param array          $renderData ['templateTag' => '{html}']
     * @param array          $options
     *
     * @return string
     */
    public function __invoke(
        Content $layout,
        array $renderData,
        array $options = []
    ): string
    {
        $renderServiceName = $layout->getProperty(
            PropertiesLayout::RENDERER,
            $this->defaultRenderServiceName
        );

        /** @var RenderLayout $render */
        $render = $this->serviceContainer->get(
            $renderServiceName
        );

        return $render->__invoke(
            $layout,
            $renderData,
            $options
        );
    }
}
