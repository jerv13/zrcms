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
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyException
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
