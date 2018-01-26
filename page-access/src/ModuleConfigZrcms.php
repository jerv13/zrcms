<?php

namespace Zrcms\PageAccess;

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
             * ===== ZRCMS Fields =====
             * ['{model-name}' => '{fields-config}']
             */
            'zrcms-fields' => [
                'page-version' => [
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
