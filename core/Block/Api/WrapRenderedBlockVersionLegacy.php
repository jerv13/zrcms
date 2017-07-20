<?php

namespace Zrcms\Core\Block\Api;

use Zrcms\Core\Block\Api\Repository\FindBlockComponent;
use Zrcms\Core\Block\Model\Block;
use Zrcms\Core\Block\Model\PropertiesBlock;
use Zrcms\Core\Block\Model\PropertiesBlockComponent;

class WrapRenderedBlockLegacy implements WrapRenderedBlock
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
    public function __invoke(string $innerHtml, Block $block): string
    {
        $blockComponent = $this->findBlockComponent->__invoke(
            $block->getBlockComponentName()
        );

        $rowNumber = $block->getRequiredLayoutProperty(
            PropertiesBlock::LAYOUT_PROPERTIES_ROW_NUMBER
        );
        $renderOrder = $block->getRequiredLayoutProperty(
            PropertiesBlock::LAYOUT_PROPERTIES_RENDER_ORDER
        );
        $columnClass = $block->getRequiredLayoutProperty(
            PropertiesBlock::LAYOUT_PROPERTIES_COLUMN_CLASS
        );

        $id = $block->getId();

        $editor = $blockComponent->getProperty(PropertiesBlockComponent::EDITOR, '');

        return "\n"
        . '<div class="rcmPlugin RcmResponsiveImage ' . $columnClass . '" '
        . 'data-rcmpluginname="RcmResponsiveImage" '
        . 'data-rcmplugindefaultclass="rcmPlugin RcmResponsiveImage" '
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
