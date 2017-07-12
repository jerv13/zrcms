<?php

namespace Zrcms\Core\Block\Model;

use Zrcms\ContentVersionControl\Model\Content;

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
     * Unique name
     *
     * @return string
     */
    public function getSourceName(): string;

    /**
     * Directory of template files
     *
     * @return string
     */
    public function getDirectory(): string;

    /**
     * Service name of render
     *
     * @return string
     */
    public function getRenderer(): string;

    /**
     * Can the html be cached
     *
     * @return bool
     */
    public function isCacheable(): bool;

    /**
     * Admin fields
     *
     * @return array
     */
    public function getFields(): array;

    /**
     * Default config values
     *
     * @return array
     */
    public function getDefaultConfig(): array;

    /**
     * Extra properties
     *
     * @return array
     */
    public function getProperties(): array;

    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function getProperty(string $name, $default = null);
}
