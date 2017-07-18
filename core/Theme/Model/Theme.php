<?php

namespace Zrcms\Core\Theme\Model;

use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Theme extends Content
{
    /**
     * Unique Name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Directory where files are located
     *
     * @return string
     */
    public function getDirectory(): string;

    /**
     * List of Layouts
     *
     * @return array
     */
    public function getLayouts(): array;

    /**
     * @param string      $name
     * @param Layout|null $default
     *
     * @return Layout|null
     */
    public function getLayout(
        string $name,
        Layout $default = null
    );

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasLayout(
        string $name
    ): bool;

    /**
     * @return Layout
     */
    public function getDefaultLayout();
}
