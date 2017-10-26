<?php

namespace Zrcms\ContentCore\Container\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ContainerBasic extends ContainerAbstract implements Container
{
    /**
     * @param array $properties
     */
    public function __construct(array $properties)
    {
        parent::__construct($properties);
    }
}
