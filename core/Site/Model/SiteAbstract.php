<?php

namespace Zrcms\Core\Site\Model;

use Zrcms\Content\Model\ContentAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class SiteAbstract extends ContentAbstract implements Site
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
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        $this->host = Param::getRequired(
            $properties,
            SiteProperties::HOST
        );

        $this->theme = Param::getRequired(
            $properties,
            SiteProperties::THEME
        );
        ;
        $this->locale = Param::getRequired(
            $properties,
            SiteProperties::LOCALE
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
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
}
