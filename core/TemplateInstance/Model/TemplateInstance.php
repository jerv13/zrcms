<?php

namespace Zrcms\Core\TemplateInstance\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface TemplateInstance
{
    /**
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
