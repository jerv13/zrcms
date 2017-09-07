<?php

namespace Zrcms\ContentCore\Site\Model;

use Zrcms\Content\Model\PropertiesContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesSiteVersion extends PropertiesSite
{
    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            PropertiesContentVersion::ID => '',
            self::THEME_NAME => '',
            self::LOCALE => '',
            self::LAYOUT => '',
            self::COUNTRY_ISO3 => '',
            self::LANGUAGE_ISO_939_2T => '',
            self::TITLE => '',
            self::LOGIN_PAGE => '',
            self::NOT_AUTHORIZED_PAGE => '',
            self::NOT_FOUND_PAGE => '',
            self::STATUS_PAGES => [
                '401' => '/not-authorized',
                '404' => '/not-found'
            ],
            self::FAVICON => '',
        ];
}
