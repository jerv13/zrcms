<?php

namespace Zrcms\ContentCore\Site\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\ContentVersionAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class SiteVersionAbstract extends ContentVersionAbstract implements SiteVersion
{
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
        Param::assertHas(
            $properties,
            PropertiesSiteVersion::THEME_NAME,
            PropertyMissingException::build(
                PropertiesSiteVersion::THEME_NAME,
                $properties,
                get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            PropertiesSiteVersion::LOCALE,
            PropertyMissingException::build(
                PropertiesSiteVersion::LOCALE,
                $properties,
                get_class($this)
            )
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
        return $this->getProperty(
            PropertiesSiteVersion::THEME_NAME,
            ''
        );
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->getProperty(
            PropertiesSiteVersion::LOCALE,
            'en_US'
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
            PropertiesSiteVersion::STATUS_PAGES,
            []
        );

        return Param::getString(
            $statusPages,
            $httpStatus,
            $default
        );
    }
}
