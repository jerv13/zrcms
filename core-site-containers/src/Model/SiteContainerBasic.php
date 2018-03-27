<?php

namespace Zrcms\CoreSiteContainer\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SiteContainerBasic extends SiteContainerAbstract implements SiteContainer
{
    /**
     * @param array $properties
     */
    public function __construct(array $properties)
    {
        parent::__construct($properties);
    }
}
