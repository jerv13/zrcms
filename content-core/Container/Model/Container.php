<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Container extends Content
{
    /**
     * This couples block versions to containers
     *
     * @return array
     */
    public function getBlockVersions(): array;
}
