<?php

namespace Zrcms\ContentCoreConfigDataSource\View\Api;

use Zrcms\ContentCoreConfigDataSource\Content\Api\ReadComponentConfigJsonFileAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewComponentConfigJsonFile
    extends ReadComponentConfigJsonFileAbstract
    implements ReadViewComponentConfig
{
    const JSON_FILE_NAME = 'view.json';

    public function __construct()
    {
        parent::__construct(self::JSON_FILE_NAME);
    }
}
