<?php

namespace Zrcms\Core\BlockInstance\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\Core\BlockInstance\Api\Repository\GetBlockInstanceData;
use Zrcms\Core\BlockInstance\Model\BlockInstance;
use Zrcms\Core\BlockInstance\Model\BlockInstanceRenderProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockInstanceRenderDataBasic implements GetBlockInstanceRenderData
{
    /**
     * @var GetBlockInstanceData
     */
    protected $getBlockInstanceData;

    /**
     * @param GetBlockInstanceData $getBlockInstanceData
     */
    public function __construct(
        GetBlockInstanceData $getBlockInstanceData
    ) {
        $this->getBlockInstanceData = $getBlockInstanceData;
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
        return [
            BlockInstanceRenderProperties::ID
            => $blockInstance->getId(),
            BlockInstanceRenderProperties::CONFIG
            => $blockInstance->getConfig(),
            BlockInstanceRenderProperties::DATA
            => $this->getBlockInstanceData->__invoke(
                $blockInstance,
                $request
            )
        ];
    }
}
