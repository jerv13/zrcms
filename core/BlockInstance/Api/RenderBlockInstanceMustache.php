<?php

namespace Zrcms\Core\BlockInstance\Api;

use Phly\Mustache\Mustache;
use Phly\Mustache\Resolver\DefaultResolver;
use Zrcms\Core\Block\Api\FindBlock;
use Zrcms\Core\Block\Model\Block;
use Zrcms\Core\BlockInstance\Model\BlockInstanceData;

class RenderBlockInstanceMustache implements RenderBlockInstance
{
    protected $findBlock;

    public function __construct(FindBlock $findBlock)
    {
        $this->findBlock = $findBlock;
    }

    /**
     * @param BlockInstanceData $blockInstance
     * @param array             $options
     *
     * @return string
     */
    public function __invoke(
        BlockInstanceData $blockInstance,
        array $options = []
    ): string
    {
        /** @var Block $block */
        $block = $this->findBlock->__invoke($blockInstance->getBlockName());

        $resolver = new DefaultResolver();
        $resolver->addTemplatePath($block->getDirectory());

        $mustache = new Mustache();
        $mustache->getResolver()->attach($resolver);

        $viewData = [
            'id' => $blockInstance->getUid(),
            'config' => $blockInstance->getConfig(),
            'data' => $blockInstance->getData()
        ];

        return $mustache->render('template', $viewData);
    }
}
