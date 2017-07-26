<?php

namespace Zrcms\ContentCore\Block\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponent;
use Zrcms\ContentCore\Block\Model\Block;
use Zrcms\ContentCore\Block\Model\BlockComponent;
use Zrcms\ContentCore\Block\Model\PropertiesBlockComponent;

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
     * @param array         $renderData ['render-tag' => '{html}']
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

        if (get_class($renderBlock) == get_class($this)) {
            throw new \Exception(
                'Class ' . get_class($this) . ' can not use itself as service.'
            );
        }

        return $renderBlock->__invoke(
            $block,
            $renderData,
            $options
        );
    }
}
