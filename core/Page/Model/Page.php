<?php

namespace Zrcms\Core\Page\Model;

use Zrcms\Core\Container\Model\Container;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Page extends Container
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
