<?php

namespace Zrcms\ContentCore\Site\Fields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsSiteVersion extends FieldsSite
{
    const HOST = 'host';

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
            [
                'name' => self::HOST,
                'type' => 'text',
                'label' => 'Host Name',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
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
                'default' => 'primary',
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
