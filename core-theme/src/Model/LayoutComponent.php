<?php

namespace Zrcms\CoreTheme\Model;

use Zrcms\Core\Model\Component;
use Zrcms\CoreTheme\Fields\FieldsThemeComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface LayoutComponent extends Component
{
    const PRIMARY_NAME = FieldsThemeComponent::DEFAULT_PRIMARY_LAYOUT_NAME;

    /**
     * @return string
     */
    public function getThemeName(): string;

    /**
     * @return string
     */
    public function getHtml(): string;
}
