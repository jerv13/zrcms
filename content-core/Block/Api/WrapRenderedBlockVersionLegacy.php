<?php

namespace Zrcms\ContentCore\Block\Api;

use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponent;
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
     */
    public function __invoke(
        string $innerHtml,
        Block $block
    ): string
    {
        $blockComponent = $this->findBlockComponent->__invoke(
            $block->getBlockComponentName()
        );

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

        return "\n"
        . '<div class="zrcms-block rcmPlugin ' . $componentName . ' ' . $columnClass . '" '
        . 'data-rcmpluginname="' . $componentName . '" '
        . 'data-rcmplugindefaultclass="rcmPlugin ' . $componentName . '" '
        . 'data-rcmplugincolumnclass="' . $columnClass . '" '
        . 'data-rcmpluginrownumber="' . $rowNumber . '" '
        . 'data-rcmpluginrenderordernumber="' . $renderOrder . '" '
        . 'data-rcmplugininstanceid="' . $id . '" '
        . 'data-rcmpluginwrapperid="' . $id . '" ' //Deprecated
        . 'data-rcmsitewideplugin="" ' //Deprecated
        . 'data-rcmplugindisplayname="" ' //Deprecated
        . 'data-block-editor="' . $editor . '">'
        . "\n"
        . ' <div class="rcmPluginContainer">'
        . $innerHtml
        . ' </div>'
        . "\n"
        . '</div>'
        . "\n";
    }
}
