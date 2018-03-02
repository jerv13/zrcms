<?php

namespace Zrcms\PageAccess;

use Zrcms\CorePage\Fields\FieldsPageVersion;
use Zrcms\PageAccess\Fields\FieldsPageAccess;

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
                FieldsPageVersion::FIELD_MODEL_NAME => [
                    [
                        'name' => FieldsPageAccess::PAGE_ACCESS_OPTIONS,
                        'type' => 'text',
                        'label' => 'Page Access Options',
                        'required' => false,
                        'default' => [],
                        'options' => [],
                    ],
                ],
            ],
        ];
    }
}
