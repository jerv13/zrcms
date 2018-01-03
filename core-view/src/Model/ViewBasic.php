<?php

namespace Zrcms\CoreView\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ViewBasic extends ViewAbstract implements View
{
    /**
     * @param array $properties
     *
     * @throws \Exception
     * @throws \Zrcms\Param\Exception\ParamMissing
     */
    public function __construct(array $properties)
    {
        parent::__construct($properties);
    }
}
