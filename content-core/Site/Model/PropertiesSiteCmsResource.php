<?php

namespace Zrcms\ContentCore\Site\Model;

use Zrcms\Content\Model\PropertiesCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesSiteCmsResource extends PropertiesCmsResource
{
    const HOST = 'host';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
            self::CONTENT_VERSION_ID => '',
            self::PUBLISHED => true,
            self::HOST => '',
        ];
}
