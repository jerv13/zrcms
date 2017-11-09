<?php

namespace Zrcms\ContentCore\Block\Api;

use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponent;
use Zrcms\ContentCore\Block\Exception\BlockComponentMissing;
use Zrcms\ContentCore\Block\Model\Block;
use Zrcms\ContentCore\Block\Fields\FieldsBlock;
use Zrcms\ContentCore\Block\Fields\FieldsBlockComponent;

class WrapRenderedBlockVersionLegacy implements WrapRenderedBlockVersion
{
    /**
     * @var FindBlockComponent
     */
    protected $findBlockComponent;

    /**
     * @param FindBlockComponent $findBlockComponent
     */
    public function __construct(FindBlockComponent $findBlockComponent)
    {
        $this->findBlockComponent = $findBlockComponent;
    }

    /**
     * @param string $innerHtml
     * @param Block  $block
     *
     * @return string
     * @throws BlockComponentMissing
     */
    public function __invoke(
        string $innerHtml,
        Block $block
    ): string {
        $blockComponent = $this->findBlockComponent->__invoke(
            $block->getBlockComponentName()
        );

        if (empty($blockComponent)) {
            // bockComponent my have been removed, so we return innerHtml
            return $innerHtml;
        }

        $rowNumber = $block->getRequiredLayoutProperty(
            FieldsBlock::LAYOUT_PROPERTIES_ROW_NUMBER
        );
        $renderOrder = $block->getRequiredLayoutProperty(
            FieldsBlock::LAYOUT_PROPERTIES_RENDER_ORDER
        );
        $columnClass = $block->getRequiredLayoutProperty(
            FieldsBlock::LAYOUT_PROPERTIES_COLUMN_CLASS
        );

        $id = $block->getId();

        $editor = $blockComponent->getProperty(FieldsBlockComponent::EDITOR, '');

        $componentName = $blockComponent->getName();

        // @todo REMOVE rcmPlugin and rcmPluginContainer class
        // @todo REMOVE data-rcm... attributes
        return "\n"
        . '<div class="content-block rcmPlugin ' . $componentName . ' ' . $columnClass . '"'
        . ' block-name="' . $componentName . '"'
        . ' default-class="content-block rcmPlugin ' . $componentName . '"'
        . ' column-class="' . $columnClass . '"'
        . ' row-number="' . $rowNumber . '"'
        . ' render-order="' . $renderOrder . '"'
        . ' instance-id="' . $id . '"'
        . ' data-rcmpluginname="' . $componentName . '"'
        . ' data-rcmplugindefaultclass="content-block rcmPlugin ' . $componentName . '"'
        . ' data-rcmplugincolumnclass="' . $columnClass . '"'
        . ' data-rcmpluginrownumber="' . $rowNumber . '"'
        . ' data-rcmpluginrenderordernumber="' . $renderOrder . '"'
        . ' data-rcmplugininstanceid="' . $id . '"'
        . ' data-rcmpluginwrapperid="' . $id . '"' //Deprecated
        . ' data-rcmsitewideplugin=""' //Deprecated
        . ' data-rcmplugindisplayname=""' //Deprecated
        . ' data-block-editor="' . $editor . '">'
        . "\n"
        . ' <div class="content-block-container rcmPluginContainer">'
        . $innerHtml
        . ' </div>'
        . "\n"
        . '</div>'
        . "\n";
    }
}
