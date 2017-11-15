<?php

namespace Zrcms\ContentCore\View\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ViewBasic extends ViewAbstract implements View
{
    /**
     * @param array $properties
     */
    public function __construct(array $properties)
    {
        parent::__construct($properties);
    }
}
