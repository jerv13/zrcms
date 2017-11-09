<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface LayoutVersion extends Layout, ContentVersion
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
