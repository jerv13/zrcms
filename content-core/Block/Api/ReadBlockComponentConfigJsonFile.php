<?php

namespace Zrcms\ContentCore\Block\Api;

use Zrcms\Content\Api\ReadComponentConfigJsonFileAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadBlockComponentConfigJsonFile
    extends ReadComponentConfigJsonFileAbstract
    implements ReadBlockComponentConfig
{
    const JSON_FILE_NAME = 'block.json';

    public function __construct()
    {
        parent::__construct(self::JSON_FILE_NAME);
    }
}
