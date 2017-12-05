<?php

namespace Zrcms\ContentCore\Block\Api\Render;

use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Block\Api\Component\FindBlockComponent;
use Zrcms\ContentCore\Block\Fields\FieldsBlockComponent;
use Zrcms\ContentCore\Block\Model\Block;
use Zrcms\ContentCore\Block\Model\BlockComponent;
use Zrcms\ContentCore\Block\Model\ServiceAliasBlock;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

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
     * @var GetServiceFromAlias
     */
    protected $getServiceFromAlias;

    /**
     * @var string
     */
    protected $serviceAliasNamespace;

    /**
     * @var RenderBlockMissing
     */
    protected $renderBlockMissing;

    /**
     * @var string
     */
    protected $defaultRenderServiceName;

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param FindBlockComponent  $findBlockComponent
     * @param RenderBlockMissing  $renderBlockMissing
     * @param string              $defaultRenderServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        FindBlockComponent $findBlockComponent,
        RenderBlockMissing $renderBlockMissing,
        string $defaultRenderServiceName = RenderBlockMustache::class
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasBlock::ZRCMS_CONTENT_RENDERER;
        $this->findBlockComponent = $findBlockComponent;
        $this->renderBlockMissing = $renderBlockMissing;
        $this->defaultRenderServiceName = $defaultRenderServiceName;
    }

    /**
     * @param Block|Content $block
     * @param array         $renderTags ['render-tag' => '{html}']
     * @param array         $options
     *
     * @return string
     * @throws \Exception
     */
    public function __invoke(
        Content $block,
        array $renderTags,
        array $options = []
    ): string {
        /** @var BlockComponent $blockComponent */
        $blockComponent = $this->findBlockComponent->__invoke(
            $block->getBlockComponentName()
        );

        if (empty($blockComponent)) {
            return $this->renderBlockMissing->__invoke(
                $block,
                $renderTags,
                $options
            );
        }

        // Get version renderer or use default
        $renderServiceAlias = $blockComponent->getProperty(
            FieldsBlockComponent::RENDERER,
            ''
        );

        /** @var RenderBlock $renderBlock */
        $renderBlock = $this->getServiceFromAlias->__invoke(
            $this->serviceAliasNamespace,
            $renderServiceAlias,
            RenderBlock::class,
            $this->defaultRenderServiceName
        );

        ServiceCheck::assertNotSelfReference($this, $renderBlock);

        return $renderBlock->__invoke(
            $block,
            $renderTags,
            $options
        );
    }
}
