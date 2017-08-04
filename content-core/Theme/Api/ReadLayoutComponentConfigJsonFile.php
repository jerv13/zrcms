<?php

namespace Zrcms\ContentCore\Theme\Api;

use Zrcms\Content\Api\ReadComponentConfigJsonFileAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadLayoutComponentConfigJsonFile
    extends ReadComponentConfigJsonFileAbstract
    implements ReadLayoutComponentConfig
{
    const JSON_FILE_NAME = 'layout.json';

    public function __construct()
    {
        parent::__construct(self::JSON_FILE_NAME);
    }
}
