<?php

namespace Zrcms\CoreBlock\Api\Render;

use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\CoreBlock\Exception\BlockComponentMissing;
use Zrcms\CoreBlock\Model\Block;
use Zrcms\CoreBlock\Fields\FieldsBlock;
use Zrcms\CoreBlock\Fields\FieldsBlockComponent;

class WrapRenderedBlockVersionLegacy implements WrapRenderedBlockVersion
{
    /**
     * @var FindComponent
     */
    protected $findComponent;

    /**
     * @param FindComponent $findComponent
     */
    public function __construct(FindComponent $findComponent)
    {
        $this->findComponent = $findComponent;
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
    ): string {
        $blockComponent = $this->findComponent->__invoke(
            'block',
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

        $editor = $blockComponent->findProperty(FieldsBlockComponent::EDITOR, '');

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
