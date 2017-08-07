<?php

namespace Zrcms\ContentCore\ViewRenderDataGetter\Model;

use Zrcms\Content\Model\ComponentConfigFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ViewRenderDataGetterComponentConfigFields extends ComponentConfigFields
{
    /**
     * Default values
     *
     * @var array
     */
    protected $fields
        = [
            self::NAME => '',
            self::CREATED_BY_USER_ID => '',
            self::CREATED_REASON => '',
        ];
}
