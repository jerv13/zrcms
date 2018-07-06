<?php

namespace Zrcms\BlockConfigJsonWhitelist;

use Zrcms\BlockConfigJsonWhitelist\Fields\FieldsBlockConfigJsonWhitelist;
use Zrcms\CoreBlock\Fields\FieldsBlockVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigZrcms
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            /**
             * ===== Fields =====
             * ['{model-name}' => '{fields-config}']
             */
            'field-rat-fields' => [
                FieldsBlockVersion::FIELD_MODEL_NAME => [
                    [
                        'name' => FieldsBlockConfigJsonWhitelist::BLOCK_CONFIG_JSON,
                        'type' => 'array',
                        'label' => 'Block config whitelist',
                        'required' => false,
                        'default' => [],
                        'options' => [],
                    ],
                ],
            ],
        ];
    }
}
