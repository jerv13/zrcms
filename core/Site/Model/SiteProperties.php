<?php

namespace Zrcms\Core\Site\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface SiteProperties
{
    //
    const HOST = 'host';
    // Theme name: 'GuestResponsive'
    const THEME = 'theme';
    //
    const LOCALE = 'locale';

    const LAYOUT = 'layout';

    // ISO3 Country code: 'USA'
    const COUNTRY_ISO3 = 'countryIso3';
    // Path to favicon: '/images/favicon.ico'
    const FAVICON = 'favicon';
    // ISO 639-2/T Language Code: 'eng'
    const LANGUAGE_ISO_939_2T = 'languageIso9392t';
    // Login page path: 'login'
    const LOGIN_PAGE = 'loginPage';

    // Not authorized (401) page path: 'not-authorized'
    const NOT_AUTHORIZED_PAGE = 'notAuthorizedPage';
    // Not found (404) page path: 'not-found
    const NOT_FOUND_PAGE = 'notFoundPage';
    // Site title
    const TITLE = 'title';
}
