<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api;

use Zrcms\Content\Model\Trackable;
use Zrcms\ContentCoreConfigDataSource\Block\Model\BlockComponentConfigFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockConfigFields
{
    /**
     * @var array
     */
    protected $fields
        = [
            BlockComponentConfigFields::NAME => '',
            BlockComponentConfigFields::LOCATION => null,
            BlockComponentConfigFields::CATEGORY => null,
            BlockComponentConfigFields::LABEL => null,
            BlockComponentConfigFields::DESCRIPTION => null,
            BlockComponentConfigFields::RENDERER => null,
            BlockComponentConfigFields::DATA_PROVIDER => null,
            BlockComponentConfigFields::ICON => null,
            BlockComponentConfigFields::CACHEABLE => false,
            BlockComponentConfigFields::FIELDS => [],
            BlockComponentConfigFields::DEFAULT_CONFIG => [],
            BlockComponentConfigFields::CREATED_BY_USER_ID => Trackable::UNKNOWN_USER_ID,
            BlockComponentConfigFields::CREATED_REASON => Trackable::UNKNOWN_REASON
        ];

    /**
     * @return array
     */
    public function __invoke()
    {
        return $this->fields;
    }
}
