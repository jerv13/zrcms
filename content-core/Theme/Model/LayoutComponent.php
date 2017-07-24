<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface LayoutComponent extends Component
{
    const PRIMARY_NAME = 'primary';

    /**
     * @return string
     */
    public function getThemeName(): string;

    /**
     * @return string
     */
    public function getHtml(): string;
}
