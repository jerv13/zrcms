<?php

namespace Zrcms\Core\Container\Model;

use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Container extends Content
{
    /**
     * <identifier>
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * @return array [BlockInstance]
     */
    public function getBlockInstances(): array;
}
