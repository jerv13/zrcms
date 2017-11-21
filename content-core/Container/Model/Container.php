<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Block\Model\BlockVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Container extends Content
{
    /**
     * This couples block versions to containers
     *
     * @return BlockVersion[]
     */
    public function getBlockVersions(): array;

    /**
     * @param string $id
     *
     * @return BlockVersion|null
     */
    public function findBlockVersion(string $id);
}
