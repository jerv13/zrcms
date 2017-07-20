<?php

namespace Zrcms\Core\Page\Model;

use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Page extends Content
{
    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return string
     */
    public function getKeywords(): string;
}
