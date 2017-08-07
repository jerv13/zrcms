<?php

namespace Zrcms\ContentCore\ViewLayoutTags\Api\Repository;

use Zrcms\Content\Api\Repository\ReadComponentConfigJsonFileAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewLayoutTagsGetterComponentConfigJsonFile
    extends ReadComponentConfigJsonFileAbstract
    implements ReadViewLayoutTagsGetterComponentConfig
{
    const JSON_FILE_NAME = 'view-layout-tags.json';

    public function __construct()
    {
        parent::__construct(self::JSON_FILE_NAME);
    }
}
