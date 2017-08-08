<?php

namespace Zrcms\ContentCore\Block\Model;

use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Block extends Content
{
    /**
     * @return string
     */
    public function getBlockComponentName(): string;

    /**
     * The instance config for this block instance.
     *
     * @return array
     */
    public function getConfig(): array;

    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function getConfigValue(string $name, $default = null);

    /**
     * @return array
     */
    public function getLayoutProperties(): array;

    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function getLayoutProperty(string $name, $default = null);

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getRequiredLayoutProperty(string $name);
}
