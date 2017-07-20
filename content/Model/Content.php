<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Content extends Immutable, Properties
{
    /**
     * @return string
     */
    public function getId();
}
