<?php

namespace Zrcms\ContentCore\Site\Model;

use Zrcms\Content\Model\ContentVersionAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class SiteVersionAbstract extends ContentVersionAbstract implements SiteVersion
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
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        array $properties,
        string $createdByUserId,
        string $createdReason
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
            $properties,
            $createdByUserId,
            $createdReason
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
