<?php

namespace Zrcms\Core\Block\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\Block\Api\GetMergedConfig;
use Zrcms\Core\Block\Api\Repository\GetBlockData;
use Zrcms\Core\Block\Model\Block;
use Zrcms\Core\Block\Model\PropertiesBlock;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockRenderDataBasic implements GetBlockRenderData
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
     * @return array ['templateTag' => '{html}']
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
            PropertiesBlock::RENDER_DATA_ID
            => $block->getId(),

            PropertiesBlock::RENDER_DATA_CONFIG
            => $config,

            PropertiesBlock::RENDER_DATA_DATA
            => $this->getBlockData->__invoke(
                $block,
                $request
            )
        ];
    }
}
