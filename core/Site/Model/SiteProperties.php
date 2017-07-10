<?php

namespace Zrcms\Core\Site\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SiteProperties
{
    // ISO3 Country code: 'USA'
    const KEY_COUNTRY_ISO3 = 'countryIso3';
    // Path to favicon: '/images/favicon.ico'
    const KEY_FAVICON = 'favicon';
    // ISO 639-2/T Language Code: 'eng'
    const KEY_LANGUAGE_ISO_939_2T = 'languageIso9392t';
    // Login page path: 'login'
    const KEY_LOGIN_PAGE = 'loginPage';
    // Theme name: 'GuestResponsive'
    const KEY_THEME = 'theme';
    // Not authorized (401) page path: 'not-authorized'
    const KEY_NOT_AUTHORIZED_PAGE = 'notAuthorizedPage';
    // Not found (404) page path: 'not-found
    const KEY_NOT_FOUND_PAGE = 'notFoundPage';
    // Site title
    const KEY_TITLE = 'title';
}
