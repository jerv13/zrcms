<?php

namespace Zrcms\ClientReactBlockRenderer;

use Zrcms\Core\Model\Content;
use Zrcms\CoreBlock\Api\Render\RenderBlock;
use Zrcms\CoreBlock\Model\Block;

class RenderBlockClientReact implements RenderBlock
{
    /**
     * @param Content|Block $block
     * @param array         $renderTags
     * @param array         $options
     *
     * @return string
     */
    public function __invoke(
        Content $block,
        array $renderTags,
        array $options = []
    ): string {
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
