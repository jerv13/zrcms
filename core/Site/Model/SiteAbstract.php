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
     * Theme name
     *
     * @var string
     */
    protected $themeName;

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
        $this->id = Param::getRequired(
            $properties,
            SiteProperties::HOST
        );

        $this->host = Param::getRequired(
            $properties,
            SiteProperties::HOST
        );

        $this->themeName = Param::getRequired(
            $properties,
            SiteProperties::THEME_NAME
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
    public function getThemeName(): string
    {
        return $this->themeName;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }
}
