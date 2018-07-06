<?php

namespace Zrcms\ClientReactBlockRenderer;

use Reliv\WhiteRat\FilterInterface;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Model\Content;
use Zrcms\CoreBlock\Api\Render\RenderBlock;
use Zrcms\CoreBlock\Exception\BlockComponentMissing;
use Zrcms\CoreBlock\Model\Block;
use Zrcms\CoreBlock\Model\BlockComponent;

class RenderBlockClientReact implements RenderBlock
{
    protected $findComponent;

    /**
     * RenderBlockClientReact constructor.
     * @param FindComponent $findComponent
     */
    public function __construct(
        FindComponent $findComponent
    ) {
        $this->findComponent = $findComponent;
    }

    /**
     * @param Block|Content $block
     * @param array $renderTags ['render-tag' => '{html}']
     * @param array $options
     *
     * @return string
     * @throws BlockComponentMissing
     * @throws \Exception
     */
    public function __invoke(
        Content $block,
        array $renderTags,
        array $options = []
    ): string {
        /** @var BlockComponent $blockComponent */
        $blockComponent = $this->findComponent->__invoke(
            'block',
            $block->getBlockComponentName()
        );

        if (empty($blockComponent)) {
            throw new BlockComponentMissing(
                "BlockComponent not found: (" . $block->getBlockComponentName() . ")"
            );
        }

        /**
         * We do NOT send the un-whitelisted standard "config" field to the client for security reasons.
         * We instead replace it with the whitelisted "configJson"
         */
        $clientBlockData = [
            'id' => $renderTags['id'],
            'data' => $renderTags['data'],
            'config' => json_decode($renderTags['configJson']), // "configJson" is pre-white-listed
        ];

        $reactAppDivId = 'renderClientReactBlock' . $block->getId();

        return '<div id="' . $reactAppDivId . '"></div>'
            . '<script>'
            . 'clientReactBlockRenderer.renderBlock('
            . 'document.getElementById(' . json_encode($reactAppDivId) . '),'
            . json_encode($block->getBlockComponentName()) . ','
            . json_encode($clientBlockData)
            . ');' .
            '</script>';
    }
}
