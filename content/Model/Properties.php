<?php

namespace Zrcms\Content\Model;

use Zrcms\Param\Exception\ParamMissingException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Properties
{
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

    /**
     * @param string $name
     *
     * @return mixed
     * @throws ParamMissingException
     */
    public function getPropertyRequired(string $name);

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasProperty(string $name): bool;
}
