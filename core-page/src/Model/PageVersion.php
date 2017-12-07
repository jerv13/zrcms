<?php

namespace Zrcms\CorePage\Model;

use Zrcms\Core\Model\ContentVersion;

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
