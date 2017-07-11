<?php

namespace Zrcms\CoreConfigDataSource\Block\Api;

use Zrcms\CoreConfigDataSource\Block\Model\BlockConfigFields;

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
            'name' => BlockConfigFields::NAME,
            'directory' => BlockConfigFields::DIRECTORY,
            'type' => BlockConfigFields::CATEGORY,
            'display' => BlockConfigFields::LABEL,
            'tooltip' => BlockConfigFields::DESCRIPTION,
            'icon' => BlockConfigFields::ICON,
            'canCache' => BlockConfigFields::CACHE,
            'defaultInstanceConfig' => BlockConfigFields::CONFIG,
        ];

    /**
     * @return array
     */
    public function __invoke()
    {
        return $this->bcFields;
    }
}
