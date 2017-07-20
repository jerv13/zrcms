<?php

namespace Zrcms\Core\Block\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\ContentRevision;
use Zrcms\Core\Block\Api\GetMergedConfig;
use Zrcms\Core\Block\Api\Repository\GetBlockRevisionData;
use Zrcms\Core\Block\Model\BlockRevision;
use Zrcms\Core\Block\Model\BlockRevisionProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockRevisionRenderDataBasic implements GetBlockRevisionRenderData
{
    protected $getBlockRevisionData;
    protected $getMergedConfig;

    /**
     * @param GetBlockRevisionData $getBlockRevisionData
     * @param GetMergedConfig              $getMergedConfig
     */
    public function __construct(
        GetBlockRevisionData $getBlockRevisionData,
        GetMergedConfig $getMergedConfig
    ) {
        $this->getBlockRevisionData = $getBlockRevisionData;
        $this->getMergedConfig = $getMergedConfig;
    }

    /**
     * @param BlockRevision|ContentRevision $blockRevision
     * @param ServerRequestInterface                $request
     * @param array                                 $options
     *
     * @return array ['templateTag' => '{html}']
     */
    public function __invoke(
        ContentRevision $blockRevision,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $config = $this->getMergedConfig->__invoke(
            $blockRevision
        );

        return [
            BlockRevisionProperties::RENDER_DATA_ID
            => $blockRevision->getId(),

            BlockRevisionProperties::RENDER_DATA_CONFIG
            => $config,

            BlockRevisionProperties::RENDER_DATA_DATA
            => $this->getBlockRevisionData->__invoke(
                $blockRevision,
                $request
            )
        ];
    }
}
