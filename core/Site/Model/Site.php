<?php

namespace Zrcms\Core\Site\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Site
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getHost(): string;

    /**
     * @return string
     */
    public function getTheme(): string;

    /**
     * @return string
     */
    public function getLocale(): string;

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
