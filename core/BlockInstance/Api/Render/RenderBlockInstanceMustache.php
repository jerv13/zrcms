<?php

namespace Zrcms\Core\BlockInstance\Api\Render;

use Phly\Mustache\Mustache;
use Phly\Mustache\Resolver\DefaultResolver;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\Block\Model\Block;
use Zrcms\Core\BlockInstance\Model\BlockInstance;
use Zrcms\CoreConfigDataSource\Block\Api\FindBlock;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderBlockInstanceMustache implements RenderBlockInstance
{
    /**
     * @var FindBlock
     */
    protected $findBlock;

    /**
     * @var GetBlockInstanceRenderData
     */
    protected $getBlockInstanceRenderData;

    /**
     * @param FindBlock                  $findBlock
     * @param GetBlockInstanceRenderData $getBlockInstanceRenderData
     */
    public function __construct(
        FindBlock $findBlock,
        GetBlockInstanceRenderData $getBlockInstanceRenderData
    ) {
        $this->findBlock = $findBlock;
        $this->getBlockInstanceRenderData = $getBlockInstanceRenderData;
    }

    /**
     * @param BlockInstance|Content  $blockInstance
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string
     */
    public function __invoke(
        Content $blockInstance,
        ServerRequestInterface $request,
        array $options = []
    ): string
    {
        /** @var Block $block */
        $block = $this->findBlock->__invoke(
            $blockInstance->getBlockName()
        );

        $renderData = $this->getBlockInstanceRenderData->__invoke(
            $blockInstance,
            $request
        );

        $resolver = new DefaultResolver();
        $resolver->addTemplatePath($block->getDirectory());

        $mustache = new Mustache();
        $mustache->getResolver()->attach($resolver);

        return $mustache->render('template', $renderData);
    }
}
