<?php

namespace Zrcms\Core\Site\Model;

use Zrcms\Tracking\Model\TrackableTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class SiteAbstract implements Site
{
    use TrackableTrait;

    /**
     * @var string
     */
    protected $uid;

    /**
     * <identifier>
     *
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

    /**
     * @param string $uid
     * @param string $host
     * @param string $theme
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        string $uid,
        string $host,
        string $theme,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        $this->host = $host;
        $this->theme = $theme;
        $this->properties = $properties;
        $this->setCreatedData(
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
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
    public function getTheme(): string
    {
        return $this->theme;
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
