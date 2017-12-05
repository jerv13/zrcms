<?php

namespace Zrcms\Content\Api\Component;

use Zrcms\Content\Model\ComponentBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildComponentObjectDefault extends BuildComponentObjectAbstract implements BuildComponentObject
{
    const SERVICE_ALIAS = 'default';

    /**
     * @param string $defaultComponentClass
     */
    public function __construct(string $defaultComponentClass = ComponentBasic::class)
    {
        parent::__construct($defaultComponentClass);
    }
}
