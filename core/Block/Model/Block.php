<?php

namespace Zrcms\Core\Block\Model;

use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Block extends Content
{
    /**
     * Unique name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Directory of template files
     *
     * @return string
     */
    public function getDirectory(): string;

    /**
     * Default config values
     *
     * @return array
     */
    public function getDefaultConfig(): array;

    /**
     * @return bool
     */
    public function isCacheable(): bool;
}
