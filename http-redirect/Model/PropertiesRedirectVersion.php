<?php

namespace Zrcms\HttpRedirect\Redirect\Model;

use Zrcms\Content\Model\PropertiesContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesRedirectVersion extends PropertiesSite
{
    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            PropertiesContentVersion::ID => '',
        ];
}
