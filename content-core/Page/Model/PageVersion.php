<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PageVersion extends Page, ContentVersion
{
    /**
     * @return string
     */
    public function getSiteCmsResourceId(): string;

    /**
     * @return string
     */
    public function getPath(): string;
}
