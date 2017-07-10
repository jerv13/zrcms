<?php

namespace Zrcms\Core\Site\Model;

use Zrcms\Tracking\Model\Trackable;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Site extends Trackable
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
