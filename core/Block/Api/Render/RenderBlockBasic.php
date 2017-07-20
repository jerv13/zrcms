<?php

namespace Zrcms\Core\Block\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\Block\Api\Repository\FindBlockComponent;
use Zrcms\Core\Block\Model\Block;
use Zrcms\Core\Block\Model\BlockComponent;
use Zrcms\Core\Block\Model\PropertiesBlockComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderBlockBasic implements RenderBlock
{
    /**
     * @var FindBlockComponent
     */
    protected $findBlockComponent;

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
     * @param FindBlockComponent $findBlockComponent
     * @param string             $defaultRenderServiceName
     */
    public function __construct(
        $serviceContainer,
        FindBlockComponent $findBlockComponent,
        string $defaultRenderServiceName = RenderBlockMustache::class
    ) {
        $this->findBlockComponent = $findBlockComponent;
        $this->serviceContainer = $serviceContainer;
        $this->defaultRenderServiceName = $defaultRenderServiceName;
    }

    /**
     * @param Block|Content $block
     * @param array         $renderData ['templateTag' => '{html}']
     * @param array         $options
     *
     * @return string
     */
    public function __invoke(
        Content $block,
        array $renderData,
        array $options = []
    ): string
    {
        /** @var BlockComponent $blockComponent */
        $blockComponent = $this->findBlockComponent->__invoke(
            $block->getBlockComponentName()
        );

        // Get version renderer or use default
        $renderServiceName = $blockComponent->getProperty(
            PropertiesBlockComponent::RENDERER,
            $this->defaultRenderServiceName
        );

        /** @var RenderBlock $render */
        $renderBlock = $this->serviceContainer->get(
            $renderServiceName
        );

        return $renderBlock->__invoke(
            $block,
            $renderData,
            $options
        );
    }
}
