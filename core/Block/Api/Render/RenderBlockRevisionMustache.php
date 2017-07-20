<?php

namespace Zrcms\Core\Block\Api\Render;

use Phly\Mustache\Mustache;
use Phly\Mustache\Resolver\DefaultResolver;
use Zrcms\Content\Model\ContentRevision;
use Zrcms\Core\Block\Api\Repository\FindBlockComponent;
use Zrcms\Core\Block\Model\BlockComponent;
use Zrcms\Core\Block\Model\BlockRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderBlockRevisionMustache implements RenderBlockRevision
{
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
     * @param BlockRevision|ContentRevision $blockRevision
     * @param array                                 $renderData ['templateTag' => '{html}']
     * @param array                                 $options
     *
     * @return string
     */
    public function __invoke(
        ContentRevision $blockRevision,
        array $renderData,
        array $options = []
    ): string
    {
        /** @var BlockComponent $blockComponent */
        $blockComponent = $this->findBlockComponent->__invoke(
            $blockRevision->getBlockComponentName()
        );

        $resolver = new DefaultResolver();
        $resolver->addTemplatePath($blockComponent->getDirectory());

        $mustache = new Mustache();
        $mustache->getResolver()->attach($resolver);

        return $mustache->render('template', $renderData);
    }
}
