<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PropertiesSettable extends Properties
{
    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return void
     */
    public function setProperty(string $name, $value);
}
