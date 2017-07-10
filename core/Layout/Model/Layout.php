<?php

namespace Zrcms\Core\Layout\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Layout
{
    /**
     * @return string
     */
    public function getUid(): string;

    /**
     * <identifier>
     *
     * @return string
     */
    public function getUri(): string;

    /**
     * @return string
     */
    public function getHtml(): string;

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
