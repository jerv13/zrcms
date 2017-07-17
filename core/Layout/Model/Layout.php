<?php

namespace Zrcms\Core\Layout\Model;

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
