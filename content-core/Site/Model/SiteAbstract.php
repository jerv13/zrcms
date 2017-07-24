<?php

namespace Zrcms\ContentCore\Site\Model;

use Zrcms\Content\Model\ContentAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class SiteAbstract extends ContentAbstract implements Site
{
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
     * @param array $properties
     */
    public function __construct(
        array $properties
    ) {
        $this->themeName = Param::getRequired(
            $properties,
            PropertiesSiteVersion::THEME_NAME
        );

        $this->locale = Param::getRequired(
            $properties,
            PropertiesSiteVersion::LOCALE
        );

        parent::__construct(
            $properties
        );
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
