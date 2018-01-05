<?php

namespace Zrcms\CoreSite\Fields;

use Zrcms\Core\Fields\FieldsContent;
use Zrcms\CoreTheme\Fields\FieldsThemeComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsSite extends FieldsContent
{
    /* required */
    // Theme name: 'GuestResponsive'
    const THEME_NAME = 'theme';
    //
    const LOCALE = 'locale';

    const LAYOUT = 'layout';

    /* possibly required */
    // ISO3 Country code: 'USA'
    const COUNTRY_ISO3 = 'countryIso3';
    // ISO 639-2/T Language Code: 'eng'
    const LANGUAGE_ISO_939_2T = 'languageIso9392t';
    // Site title
    const TITLE = 'title';
    // Site keywords
    const KEYWORDS = 'keywords';
    // Site description
    const DESCRIPTION = 'description';

    /* other */
    // Login page path: 'login'
    const LOGIN_PAGE = 'loginPage';

    // Map of status code strings to page path to render
    // Example: ['401' => '/not-authorized','404' => '/not-found']
    const STATUS_PAGES = 'statusPages';

    // Path to favicon: '/images/favicon.ico'
    const FAVICON = 'favicon';

    const DEFAULT_PRIMARY_LAYOUT_NAME = FieldsThemeComponent::DEFAULT_PRIMARY_LAYOUT_NAME;

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
            [
                'name' => self::THEME_NAME,
                'type' => 'text',
                'label' => 'Theme Name',
                'required' => false,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::LOCALE,
                'type' => 'text',
                'label' => 'Locale',
                'required' => false,
                'default' => 'en_US',
                'options' => [],
            ],
            [
                'name' => self::LAYOUT,
                'type' => 'text',
                'label' => 'Layout',
                'required' => false,
                'default' => self::DEFAULT_PRIMARY_LAYOUT_NAME,
                'options' => [],
            ],
            [
                'name' => self::COUNTRY_ISO3,
                'type' => 'text',
                'label' => 'Country ISO3 Code',
                'required' => true,
                'default' => 'USA',
                'options' => [],
            ],
            [
                'name' => self::LANGUAGE_ISO_939_2T,
                'type' => 'text',
                'label' => 'Language ISO 939 2t Code',
                'required' => true,
                'default' => 'eng',
                'options' => [],
            ],
            [
                'name' => self::TITLE,
                'type' => 'text',
                'label' => 'Site Title',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::LOGIN_PAGE,
                'type' => 'text',
                'label' => 'Login Page Path',
                'required' => false,
                'default' => '/login',
                'options' => [],
            ],
            [
                'name' => self::STATUS_PAGES,
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
                'name' => self::FAVICON,
                'type' => 'text',
                'label' => 'Favicon Path',
                'required' => false,
                'default' => null,
                'options' => [],
            ],
        ];
}
