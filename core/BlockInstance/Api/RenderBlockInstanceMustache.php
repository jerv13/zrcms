<?php

namespace Zrcms\Core\BlockInstance\Api;

use Phly\Mustache\Mustache;
use Phly\Mustache\Resolver\DefaultResolver;
use Zrcms\Core\Block\Api\FindBlock;
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
