<?php

namespace Zrcms\ContentCore\Site\Model;

use Zrcms\Content\Model\PropertiesContent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesSite extends PropertiesContent
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

    /* other */
    // Login page path: 'login'
    const LOGIN_PAGE = 'loginPage';

    // Map of status code strings to page path to render
    // Example: ['401' => '/not-authorized','404' => '/not-found']
    const STATUS_PAGES = 'statusPages';

    // Path to favicon: '/images/favicon.ico'
    const FAVICON = 'favicon';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
            self::THEME_NAME => '',
            self::LOCALE => '',
            self::LAYOUT => '',
            self::COUNTRY_ISO3 => '',
            self::LANGUAGE_ISO_939_2T => '',
            self::TITLE => '',
            self::LOGIN_PAGE => '',
            self::STATUS_PAGES => [
                '401' => '/not-authorized',
                '404' => '/not-found'
            ],
            self::FAVICON => '',
        ];
}
