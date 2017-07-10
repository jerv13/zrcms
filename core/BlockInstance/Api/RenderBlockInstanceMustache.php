<?php

namespace Zrcms\Core\BlockInstance\Api;

use Zrcms\Core\Block\Api\FindBlock;
use Zrcms\Core\BlockInstance\Model\BlockInstance;
use Phly\Mustache\Mustache;
use Phly\Mustache\Resolver\DefaultResolver;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderBlockInstanceMustache implements RenderBlockInstance
{
    protected $findBlock;

    public function __construct(FindBlock $findBlock)
    {
        $this->findBlock = $findBlock;
    }
    /**
     * @param BlockInstance $blockInstance
     * @param array $options
     *
     * @return string
     */
    public function __invoke(
        BlockInstance $blockInstance,
        array $options = []
    ): string {
        /**
         * @var $blockConfig Config
         */
        $blockConfig = $this->findBlock->__invoke($blockInstance->getBlockName());

        $resolver = new DefaultResolver();
        $resolver->addTemplatePath($blockConfig->getDirectory());

        $mustache = new Mustache();
        $mustache->getResolver()->attach($resolver);

        $viewData = [
            'id' => $blockInstance->getId(),
            'config' => $blockInstance->getConfig(),
            'data' => $blockInstance->getData()
        ];

        return $mustache->render('template', $viewData);
    }
}
