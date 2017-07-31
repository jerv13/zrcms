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
            new PropertyMissingException(
                'Required property (' . PropertiesSiteVersion::THEME_NAME. ') is missing in: '
                . get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            PropertiesSiteVersion::LOCALE,
            new PropertyMissingException(
                'Required property (' . PropertiesSiteVersion::LOCALE. ') is missing in: '
                . get_class($this)
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
            ''
        );
    }
}
