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
}
