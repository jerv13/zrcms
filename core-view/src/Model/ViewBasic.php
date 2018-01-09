<?php

namespace Zrcms\CoreView\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ViewBasic extends ViewAbstract implements View
{
    /**
     * @param array $properties
     * @param null  $id
     *
     * @throws \Throwable
     * @throws \Zrcms\Param\Exception\ParamException
     */
    public function __construct(
        array $properties,
        $id = null
    ) {
        parent::__construct(
            $properties,
            $id
        );
    }
}
