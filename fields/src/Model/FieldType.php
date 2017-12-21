<?php

namespace Zrcms\Fields\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FieldType
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getValidator(): string;
}
