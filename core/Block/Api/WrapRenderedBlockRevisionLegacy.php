<?php

namespace Zrcms\Core\Block\Api;

use Zrcms\Core\Block\Api\Repository\FindBlockComponent;
use Zrcms\Core\Block\Model\BlockComponentProperties;
use Zrcms\Core\Block\Model\BlockRevision;
use Zrcms\Core\Block\Model\BlockRevisionProperties;

class WrapRenderedBlockRevisionLegacy implements WrapRenderedBlockRevision
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
     * @param string                $innerHtml
     * @param BlockRevision $blockRevision
     *
     * @return string
     */
    public function __invoke(string $innerHtml, BlockRevision $blockRevision): string
    {
        $blockComponent = $this->findBlockComponent->__invoke(
            $blockRevision->getBlockComponentName()
        );

        $rowNumber = $blockRevision->getRequiredLayoutProperty(
            BlockRevisionProperties::LAYOUT_PROPERTIES_ROW_NUMBER
        );
        $renderOrder = $blockRevision->getRequiredLayoutProperty(
            BlockRevisionProperties::LAYOUT_PROPERTIES_RENDER_ORDER
        );
        $columnClass = $blockRevision->getRequiredLayoutProperty(
            BlockRevisionProperties::LAYOUT_PROPERTIES_COLUMN_CLASS
        );

        $id = $blockRevision->getId();

        $editor = $blockComponent->getProperty(BlockComponentProperties::EDITOR, '');

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
