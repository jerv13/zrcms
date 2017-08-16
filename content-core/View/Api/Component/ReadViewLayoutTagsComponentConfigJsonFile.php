<?php

namespace Zrcms\ContentCore\View\Api\Component;

use Zrcms\Content\Api\Component\ReadComponentConfigJsonFileAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewLayoutTagsComponentConfigJsonFile
    extends ReadComponentConfigJsonFileAbstract
    implements ReadViewLayoutTagsComponentConfig
{
    const JSON_FILE_NAME = 'view-layout-tags.json';

    public function __construct()
    {
        parent::__construct(self::JSON_FILE_NAME);
    }
}
