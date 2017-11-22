<?php

namespace Zrcms\ContentCore\Block\Api\Render;

use Phly\Mustache\Mustache;
use Phly\Mustache\Resolver\DefaultResolver;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Block\Api\Component\FindBlockComponent;
use Zrcms\ContentCore\Block\Exception\BlockComponentMissing;
use Zrcms\ContentCore\Block\Model\Block;
use Zrcms\ContentCore\Block\Model\BlockComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderBlockMustache implements RenderBlock
{
    const SERVICE_ALIAS = 'mustache';

    /**
     * @var FindBlockComponent
     */
    protected $findBlockComponent;

    /**
     * @param FindBlockComponent $findBlockComponent
     */
    public function __construct(
        FindBlockComponent $findBlockComponent
    ) {
        $this->findBlockComponent = $findBlockComponent;
    }

    /**
     * @param Block|Content $block
     * @param array         $renderTags ['render-tag' => '{html}']
     * @param array         $options
     *
     * @return string
     * @throws BlockComponentMissing
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
            throw new BlockComponentMissing(
                "BlockComponent not found: (" . $block->getBlockComponentName() . ")"
            );
        }

        $resolver = new DefaultResolver();
        $resolver->addTemplatePath($blockComponent->getConfigLocation());

        $mustache = new Mustache();
        $mustache->getResolver()->attach($resolver);

        return $mustache->render('template', $renderTags);
    }
}
