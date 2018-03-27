<?php

namespace Zrcms\CoreContainer\Model;

use Zrcms\Core\Model\Content;
use Zrcms\CoreBlock\Model\BlockVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Container extends Content
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getContext(): string;

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
