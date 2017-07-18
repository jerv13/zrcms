<?php

namespace Zrcms\Core\ThemeLayout\Model;

use Zrcms\Content\Model\Content;
use Zrcms\Core\Theme\Model\Layout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ThemeLayout extends Layout, Content
{
    /**
     * @return string
     */
    public function getThemeName(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getHtml(): string;
}
