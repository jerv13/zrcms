<?php

namespace Zrcms\BlockConfigJsonWhitelist\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Reliv\WhiteRat\FilterInterface;
use Zrcms\BlockConfigJsonWhitelist\Fields\FieldsBlockConfigJsonWhitelist;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Model\Content;
use Zrcms\CoreBlock\Api\GetBlockData;
use Zrcms\CoreBlock\Api\GetMergedConfig;
use Zrcms\CoreBlock\Api\Render\GetBlockRenderTags;
use Zrcms\CoreBlock\Api\Render\GetBlockRenderTagsBasic;
use Zrcms\CoreBlock\Exception\BlockComponentMissing;
use Zrcms\CoreBlock\Fields\FieldsBlock;
use Zrcms\CoreBlock\Model\Block;
use Zrcms\CoreBlock\Model\BlockComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockRenderTagsConfigJsonWhitelist extends GetBlockRenderTagsBasic implements GetBlockRenderTags
{
    protected $getBlockData;
    protected $getMergedConfig;
    protected $findComponent;
    protected $filterWithWhitelist;

    /**
     * @param GetBlockData    $getBlockData
     * @param GetMergedConfig $getMergedConfig
     * @param FindComponent   $findComponent
     * @param FilterInterface $filterWithWhitelist
     */
    public function __construct(
        GetBlockData $getBlockData,
        GetMergedConfig $getMergedConfig,
        FindComponent $findComponent,
        FilterInterface $filterWithWhitelist
    ) {

        $this->findComponent = $findComponent;
        $this->filterWithWhitelist = $filterWithWhitelist;
        parent::__construct(
            $getBlockData,
            $getMergedConfig
        );
    }

    /**
     * @param Block|Content          $block
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string [] ['render-tag}' => '{html}']
     * @throws BlockComponentMissing
     */
    public function __invoke(
        Content $block,
        ServerRequestInterface $request,
        array $options = []
    ): array {

        $renderTags = parent::__invoke(
            $block,
            $request,
            $options
        );

        // This is for use with special rendering
        $configJson = json_encode(
            $this->getWhitelistedJsonConfig(
                $renderTags[FieldsBlock::RENDER_DATA_CONFIG],
                $block
            )
        );

        $renderTags[FieldsBlockConfigJsonWhitelist::BLOCK_CONFIG_JSON] = $configJson;

        return $renderTags;
    }

    /**
     * Note: This functionality could be moved higher up into the ZRCMS render-tags chain in the future.
     *
     * @param array         $config
     * @param Content|Block $block ,
     *
     * @return array
     * @throws BlockComponentMissing
     */
    protected function getWhitelistedJsonConfig(array $config, Content $block)
    {
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

        $configJsonWhitelist = $blockComponent->findProperty('configJsonWhitelist', null);

        if ($configJsonWhitelist === null) {
            return [];
        }

        return $this->filterWithWhitelist->__invoke(
            $config,
            $configJsonWhitelist
        );
    }
}
