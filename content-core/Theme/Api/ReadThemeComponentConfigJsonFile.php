<?php

namespace Zrcms\ContentCore\Theme\Api;

use Zrcms\Content\Api\ReadComponentConfigJsonFileAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadThemeComponentConfigJsonFile
    extends ReadComponentConfigJsonFileAbstract
    implements ReadThemeComponentConfig
{
    const JSON_FILE_NAME = 'theme.json';

    public function __construct()
    {
        parent::__construct(self::JSON_FILE_NAME);
    }
}