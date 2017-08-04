<?php

namespace Zrcms\ContentCore\Block\Api;

use Zrcms\ContentCore\Block\Model\BlockComponentConfigFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockConfigFieldsBcSubstitution
{
    /**
     * @var array
     */
    protected $bcFields
        = [
            'name' => BlockComponentConfigFields::NAME,
            'type' => BlockComponentConfigFields::CATEGORY,
            'display' => BlockComponentConfigFields::LABEL,
            'tooltip' => BlockComponentConfigFields::DESCRIPTION,
            'icon' => BlockComponentConfigFields::ICON,
            'canCache' => BlockComponentConfigFields::CACHEABLE,
            'defaultInstanceConfig' => BlockComponentConfigFields::DEFAULT_CONFIG,
        ];

    /**
     * @return array
     */
    public function __invoke()
    {
        return $this->bcFields;
    }
}
