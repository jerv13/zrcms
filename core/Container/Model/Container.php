<?php

namespace Zrcms\Core\Container\Model;

use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Container extends Content
{
    /**
     * @return array [BlockInstance]
     */
    public function getBlockInstances(): array;
}
