<?php

namespace Zrcms\CoreDoctrine\Site\Model;

use Zrcms\Core\Site\Model\SiteAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SiteHistory extends SiteAbstract implements \Zrcms\Core\Site\Model\SiteHistory
{
    /**
     * @var int
     */
    protected $id;

    /**
     * Host name or domain name
     *
     * @var string
     */
    protected $host;

    /**
     * Theme name
     *
     * @var string
     */
    protected $theme;

    /**
     * Locale used for translations and formating
     *
     * @var string
     */
    protected $locale;

    /**
     *
     * @var array
     */
    protected $properties
        = [
            // ISO3 Country code
            'countryIso3' => 'USA',
            'favicon' => '/images/favicon.ico',
            // ISO 639-2/T Language Code
            'languageIso9392t' => 'eng',
            'loginPage' => '/login',
            // default theme
            'theme' => 'GuestResponsive',
            // replaced by layout 'siteLayout' => 'GuestSitePage'
            'notAuthorizedPage' => '/not-authorized',
            'notFoundPage' => 'not-found',
            'title' => ''
        ];
}
