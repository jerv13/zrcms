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
     * getCategory
     *
     * @return string
     */
    public function getCategory(): string;

    /**
     * getLabel
     *
     * @return string
     */
    public function getLabel(): string;

    /**
     * getDescription
     *
     * @return string
     */
    public function getDescription(): string;

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
     * getIcon (URI)
     *
     * @return string
     */
    public function getIcon(): string;

    /**
     * getEditor
     *
     * @return string
     */
    public function getEditor(): string;

    /**
     * getCache
     *
     * @return bool
     */
    public function getCache(): bool;

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
