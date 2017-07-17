<?php

namespace Zrcms\Core\ThemeLayout\Model;

use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Layout extends Content
{
    /**
     * @return string
     */
    public function getHtml(): string;
}
