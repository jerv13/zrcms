<?php

namespace Zrcms\CoreBlock\Api\Render;

use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Model\Content;
use Zrcms\CoreBlock\Fields\FieldsBlockComponent;
use Zrcms\CoreBlock\Model\Block;
use Zrcms\CoreBlock\Model\BlockComponent;
use Zrcms\CoreBlock\Model\ServiceAliasBlock;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderBlockBasic implements RenderBlock
{
    /**
     * @var FindComponent
     */
    protected $findComponent;

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
     * @param FindComponent       $findComponent
     * @param RenderBlockMissing  $renderBlockMissing
     * @param string              $defaultRenderServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        FindComponent $findComponent,
        RenderBlockMissing $renderBlockMissing,
        string $defaultRenderServiceName = RenderBlockMustache::class
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasBlock::ZRCMS_CONTENT_RENDERER;
        $this->findComponent = $findComponent;
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
    ): string
    {
        /** @var BlockComponent $blockComponent */
        $blockComponent = $this->findComponent->__invoke(
            'block',
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
        $renderServiceAlias = $blockComponent->findProperty(
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
