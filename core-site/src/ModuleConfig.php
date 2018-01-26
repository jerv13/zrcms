<?php

namespace Zrcms\CoreSite;

use Zrcms\Core\Exception\IMPLEMENTATIONisREQUIRED;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourceByHost;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourcesBy;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourcesPublished;
use Zrcms\CoreSite\Api\CmsResource\UpsertSiteCmsResource;
use Zrcms\CoreSite\Api\Content\FindSiteVersion;
use Zrcms\CoreSite\Api\Content\FindSiteVersionsBy;
use Zrcms\CoreSite\Api\Content\InsertSiteVersion;
use Zrcms\CoreSite\Api\GetSiteCmsResourceByRequest;
use Zrcms\CoreSite\Fields\FieldsSiteVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    UpsertSiteCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindSiteCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindSiteCmsResourceByHost::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindSiteCmsResourcesBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindSiteCmsResourcesPublished::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindSiteVersion::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindSiteVersionsBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    InsertSiteVersion::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    GetSiteCmsResourceByRequest::class => [
                        'arguments' => [
                            FindSiteCmsResourceByHost::class,
                        ],
                    ],
                ],
            ],

            /**
             * ===== ZRCMS Field Models =====
             * ['{model-name}' => '{model-class}']
             */
            'zrcms-fields-model' => [
                'site-version' => FieldsSiteVersion::class,
            ],

            /**
             * ===== ZRCMS Fields =====
             * ['{model-name}' => '{fields-config}']
             */
            'zrcms-fields' => [
                'site-version' => [
                    [
                        'name' => FieldsSiteVersion::THEME_NAME,
                        'type' => 'text',
                        'label' => 'Theme Name',
                        'required' => false,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsSiteVersion::LOCALE,
                        'type' => 'text',
                        'label' => 'Locale',
                        'required' => false,
                        'default' => 'en_US',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsSiteVersion::LAYOUT,
                        'type' => 'text',
                        'label' => 'Layout',
                        'required' => false,
                        'default' => FieldsSiteVersion::DEFAULT_PRIMARY_LAYOUT_NAME,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsSiteVersion::COUNTRY_ISO3,
                        'type' => 'text',
                        'label' => 'Country ISO3 Code',
                        'required' => true,
                        'default' => 'USA',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsSiteVersion::LANGUAGE_ISO_939_2T,
                        'type' => 'text',
                        'label' => 'Language ISO 939 2t Code',
                        'required' => true,
                        'default' => 'eng',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsSiteVersion::TITLE,
                        'type' => 'text',
                        'label' => 'Site Title',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsSiteVersion::LOGIN_PAGE,
                        'type' => 'text',
                        'label' => 'Login Page Path',
                        'required' => false,
                        'default' => '/login',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsSiteVersion::STATUS_PAGES,
                        'type' => 'array',
                        'label' => 'Status Pages Config',
                        'required' => false,
                        'default' => [
                            '401' => '/not-authorized',
                            '404' => '/not-found'
                        ],
                        'options' => [],
                    ],
                    [
                        'name' => FieldsSiteVersion::FAVICON,
                        'type' => 'text',
                        'label' => 'Favicon Path',
                        'required' => false,
                        'default' => null,
                        'options' => [
                            'type-validator-options' => []
                        ],
                    ],
                ],
            ],
            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [

            ],
        ];
    }
}
