<?php

namespace Zrcms\ContentCore\ViewRenderDataGetter\Api\Repository;

use Zrcms\Content\Api\Repository\ReadComponentConfigJsonFileAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewRenderDataGetterComponentConfigJsonFile
    extends ReadComponentConfigJsonFileAbstract
    implements ReadViewRenderDataGetterComponentConfig
{
    const JSON_FILE_NAME = 'view-render-data-getter.json';

    public function __construct()
    {
        parent::__construct(self::JSON_FILE_NAME);
    }
}
