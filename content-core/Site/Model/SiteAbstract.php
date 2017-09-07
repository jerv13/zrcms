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
     * @param array $properties
     */
    public function __construct(
        array $properties
    ) {
        Param::assertHas(
            $properties,
            PropertiesSite::THEME_NAME,
            PropertyMissingException::build(
                PropertiesSiteVersion::THEME_NAME,
                $properties,
                get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            PropertiesSite::LOCALE,
            PropertyMissingException::build(
                PropertiesSiteVersion::LOCALE,
                $properties,
                get_class($this)
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
        return $this->getProperty(
            PropertiesSite::THEME_NAME,
            ''
        );
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->getProperty(
            PropertiesSite::LOCALE,
            ''
        );
    }

    /**
     * @param string     $httpStatus
     * @param mixed|null $default
     *
     * @return string|null
     */
    public function findStatusPage(string $httpStatus, $default = null)
    {
        $statusPages = $this->getProperty(
            PropertiesSite::STATUS_PAGES,
            []
        );

        return Param::getString(
            $statusPages,
            $httpStatus,
            $default
        );
    }
}
