<?php

namespace Zrcms\Core\Site\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class SiteAbstract implements Site
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
     * Friendly title
     *
     * @var string
     */
    protected $title;

    /**
     * ISO3 Country code
     *
     * @var string
     */
    protected $country;

    /**
     * ISO 639-2/T Language Code
     *
     * @var string
     */
    protected $language;

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
            'favicon' => '/images/favicon.ico',
            'loginPage' => '/login',
            // default theme
            'theme' => 'GuestResponsive',
            // replaced by themeInstance 'siteLayout' => 'GuestSitePage'
            'notAuthorizedPage' => '/not-authorized',
            'notFoundPage' => 'not-found'
        ];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function getProperty(string $name, $default = null)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        return $default;
    }
}
