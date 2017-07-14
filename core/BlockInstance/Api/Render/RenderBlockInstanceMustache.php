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
    protected $findBlock;

    /**
     * @param FindBlock $findBlock
     */
    public function __construct(FindBlock $findBlock)
    {
        $this->findBlock = $findBlock;
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

        $resolver = new DefaultResolver();
        $resolver->addTemplatePath($block->getDirectory());

        $mustache = new Mustache();
        $mustache->getResolver()->attach($resolver);

        return $mustache->render('template', $renderData);
    }
}
