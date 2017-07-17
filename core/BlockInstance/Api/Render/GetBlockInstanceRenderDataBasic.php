<?php

namespace Zrcms\Core\BlockInstance\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\BlockInstance\Api\GetMergedConfig;
use Zrcms\Core\BlockInstance\Api\Repository\GetBlockInstanceData;
use Zrcms\Core\BlockInstance\Model\BlockInstance;
use Zrcms\Core\BlockInstance\Model\BlockInstanceProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockInstanceRenderDataBasic implements GetBlockInstanceRenderData
{
    protected $getBlockInstanceData;
    protected $getMergedConfig;

    /**
     * @param GetBlockInstanceData $getBlockInstanceData
     * @param GetMergedConfig      $getMergedConfig
     */
    public function __construct(
        GetBlockInstanceData $getBlockInstanceData,
        GetMergedConfig $getMergedConfig
    ) {
        $this->getBlockInstanceData = $getBlockInstanceData;
        $this->getMergedConfig = $getMergedConfig;
    }

    /**
     * @param BlockInstance|Content  $blockInstance
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array ['templateTag' => '{html}']
     */
    public function __invoke(
        Content $blockInstance,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $config = $this->getMergedConfig->__invoke(
            $blockInstance
        );

        return [
            BlockInstanceProperties::RENDER_ID
            => $blockInstance->getId(),

            BlockInstanceProperties::RENDER_CONFIG
            => $config,

            BlockInstanceProperties::RENDER_DATA
            => $this->getBlockInstanceData->__invoke(
                $blockInstance,
                $request
            )
        ];
    }
}
