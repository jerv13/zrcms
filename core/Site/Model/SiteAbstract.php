<?php

namespace Zrcms\Core\Site\Model;

use Zrcms\ContentVersionControl\Model\ContentAbstract;


/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class SiteAbstract extends ContentAbstract  implements Site
{
    /**
     * <identifier>
     *
     * Host name or domain name (same as URI)
     *
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $sourceHost;

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
     * @param string $host
     * @param string $sourceHost
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     * @param string $theme
     * @param string $locale
     */
    public function __construct(
        string $host,
        string $sourceHost,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        string $theme,
        string $locale
    ) {
        $this->host = $host;
        $this->sourceHost = $sourceHost;
        $this->theme = $theme;
        $this->locale = $locale;

        parent::__construct(
            $host,
            $sourceHost,
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->getHost();
    }

    /**
     * @return string
     */
    public function getSourceUri(): string
    {
        return $this->getSourceHost();
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
    public function getSourceHost(): string
    {
        return $this->sourceHost;
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
