<?php

namespace Zrcms\Core\Page\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PagePreRendered extends Page
{
    public function getHtml(): string;
}
