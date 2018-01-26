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
             * ===== ZRCMS Field Models =====
             * ['{model-name}' => '{model-class}']
             */
            'zrcms-fields-model' => [
                'redirect-version' => FieldsRedirectVersion::class,
            ],

            /**
             * ===== ZRCMS Field Model Extends =====
             * ['{model-name}' => '{extends-model-name}']
             */
            'zrcms-fields-model-extends' => [
                'redirect-version' => 'content-version',
            ],

            /**
             * ===== ZRCMS Fields =====
             * ['{model-name}' => '{fields-config}']
             */
            'zrcms-fields' => [
                'redirect-version' => [
                    [
                        'name' => fieldsRedirectVersion::SITE_CMS_RESOURCE_ID,
                        'type' => 'id',
                        'label' => 'Site CmsResourceId',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsRedirectVersion::REQUEST_PATH,
                        'type' => 'text',
                        'label' => 'Request Path',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsRedirectVersion::REDIRECT_PATH,
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
