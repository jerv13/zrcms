<?php

namespace Zrcms\ContentCore\Block\Api;

use Zrcms\ContentCore\Block\Fields\FieldsBlockComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockConfigFields
{
    /**
     * @return array
     */
    public function __invoke()
    {
        // @todo get a real config for fields, not just the defaults
        $fieldConfig = [];
        $blockComponentConfigFields = new FieldsBlockComponentConfig($fieldConfig);

        return $blockComponentConfigFields->getFieldDefaults();
    }
}
