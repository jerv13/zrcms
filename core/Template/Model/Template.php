<?php

namespace Zrcms\Core\Template\Model;

use Zrcms\Core\Layout\Model\Layout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Template
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
    public function getLayout(string $name, Layout $default = null);

    /**
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
