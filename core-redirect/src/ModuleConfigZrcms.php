<?php

namespace Zrcms\CoreRedirect;

use Zrcms\CoreRedirect\Fields\FieldsRedirectVersion;

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
             * ===== Field Models =====
             * ['{model-name}' => '{model-class}']
             */
            'field-rat-fields-model' => [
                'redirect-version' => FieldsRedirectVersion::class,
            ],

            /**
             * ===== Field Model Extends =====
             * ['{model-name}' => '{extends-model-name}']
             */
            'field-rat-fields-model-extends' => [
                'redirect-version' => 'content-version',
            ],

            /**
             * ===== Fields =====
             * ['{model-name}' => '{fields-config}']
             */
            'field-rat-fields' => [
                FieldsRedirectVersion::FIELD_MODEL_NAME => [
                    [
                        'name' => FieldsRedirectVersion::SITE_CMS_RESOURCE_ID,
                        'type' => 'id-string',
                        'label' => 'Site CmsResourceId',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsRedirectVersion::REQUEST_PATH,
                        'type' => 'text',
                        'label' => 'Request Path',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsRedirectVersion::REDIRECT_PATH,
                        'type' => 'text',
                        'label' => 'Redirect Path',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                ],
            ],
        ];
    }
}
