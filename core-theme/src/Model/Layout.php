<?php

namespace Zrcms\CoreTheme\Model;

use Zrcms\Core\Model\Content;

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
