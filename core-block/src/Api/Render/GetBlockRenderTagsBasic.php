<?php

namespace Zrcms\CoreBlock\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Model\Content;
use Zrcms\CoreBlock\Api\GetMergedConfig;
use Zrcms\CoreBlock\Api\GetBlockData;
use Zrcms\CoreBlock\Model\Block;
use Zrcms\CoreBlock\Fields\FieldsBlock;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockRenderTagsBasic implements GetBlockRenderTags
{
    /**
     * @var GetBlockData
     */
    protected $getBlockData;

    /**
     * @var GetMergedConfig
     */
    protected $getMergedConfig;

    /**
     * @param GetBlockData    $getBlockData
     * @param GetMergedConfig $getMergedConfig
     */
    public function __construct(
        GetBlockData $getBlockData,
        GetMergedConfig $getMergedConfig
    ) {
        $this->getBlockData = $getBlockData;
        $this->getMergedConfig = $getMergedConfig;
    }

    /**
     * @param Block|Content          $block
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string [] ['render-tag}' => '{html}']
     */
    public function __invoke(
        Content $block,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $config = $this->getMergedConfig->__invoke(
            $block
        );

        return [
            FieldsBlock::RENDER_DATA_ID
            => $block->getId(),

            FieldsBlock::RENDER_DATA_CONFIG
            => $config,

            FieldsBlock::RENDER_DATA_DATA
            => $this->getBlockData->__invoke(
                $block,
                $request
            )
        ];
    }
}
