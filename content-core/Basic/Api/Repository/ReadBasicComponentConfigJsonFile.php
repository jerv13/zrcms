<?php

namespace Zrcms\ContentCore\Basic\Api\Repository;

use Zrcms\Content\Api\Repository\ReadComponentConfigJsonFileAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadBasicComponentConfigJsonFile
    extends ReadComponentConfigJsonFileAbstract
    implements ReadBasicComponentConfig
{
    const SERVICE_ALIAS = 'json';
    const JSON_FILE_NAME = 'basic.json';

    public function __construct()
    {
        parent::__construct(self::JSON_FILE_NAME);
    }
}
