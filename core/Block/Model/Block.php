<?php

namespace Zrcms\Core\Block\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Block
{
    /**
     * getName
     *
     * @return string
     */
    public function getName(): string;

    /**
     * getDirectory
     *
     * @return string
     */
    public function getDirectory(): string;

    /**
     * getRenderer
     *
     * @return string
     */
    public function getRenderer(): string;

    /**
     * getDataProvider
     *
     * @return string
     */
    public function getDataProvider(): string;

    /**
     * isCacheable
     *
     * @return bool
     */
    public function isCacheable(): bool;

    /**
     * getFields
     *
     * @return array
     */
    public function getFields(): array;

    /**
     * getDefaultConfig
     *
     * @return array
     */
    public function getDefaultConfig(): array;

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
