<?php

namespace Zrcms\ContentCore\Site\Model;

use Zrcms\Content\Exception\PropertyMissingException;
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
            PropertiesSiteVersion::THEME_NAME,
            new PropertyMissingException(
                'Required property (' . PropertiesSiteVersion::THEME_NAME. ') is missing in: '
                . get_class($this)
            )
        );

        $this->locale = Param::getRequired(
            $properties,
            PropertiesSiteVersion::LOCALE,
            new PropertyMissingException(
                'Required property (' . PropertiesSiteVersion::LOCALE. ') is missing in: '
                . get_class($this)
            )
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
