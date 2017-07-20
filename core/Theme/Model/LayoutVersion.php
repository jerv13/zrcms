<?php

namespace Zrcms\Core\Theme\Model;

use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface LayoutVersion extends Layout, ContentVersion
{
    /**
     * @return string
     */
    public function getHtml(): string;
}
