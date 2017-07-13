<?php

namespace Zrcms\Core\BlockInstance\Api\Render;

use Phly\Mustache\Mustache;
use Phly\Mustache\Resolver\DefaultResolver;
use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\Core\Block\Api\Repository\FindBlock;
use Zrcms\Core\Block\Model\Block;
use Zrcms\Core\BlockInstance\Model\BlockInstance;

class RenderBlockInstanceMustache implements RenderBlockInstance
{
    protected $findBlock;

    public function __construct(FindBlock $findBlock)
    {
        $this->findBlock = $findBlock;
    }

    /**
     * @param BlockInstance|Content $blockInstance
     * @param array                 $renderData ['templateTag' => '{html}']
     * @param array                 $options
     *
     * @return string
     */
    public function __invoke(
        Content $blockInstance,
        array $renderData,
        array $options = []
    ): string
    {
        /** @var Block $block */
        $block = $this->findBlock->__invoke($blockInstance->getBlockName());

        $resolver = new DefaultResolver();
        $resolver->addTemplatePath($block->getDirectory());

        $mustache = new Mustache();
        $mustache->getResolver()->attach($resolver);

        return $mustache->render('template', $renderData);
    }
}
