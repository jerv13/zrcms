<?php

namespace Zrcms\ContentRedirect\Model;

use Zrcms\Content\Model\PropertiesContent;
use Zrcms\Content\Model\PropertiesContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesRedirectVersion extends PropertiesContent
{
    const REDIRECT_PATH = 'redirectPath';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            PropertiesContentVersion::ID => '',
            self::REDIRECT_PATH => '',
        ];
}
