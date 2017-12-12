<?php

namespace Zrcms\CoreTheme\Model;

use Zrcms\Core\Exception\PropertyMissing;
use Zrcms\Core\Model\ContentVersionAbstract;
use Zrcms\CoreTheme\Fields\FieldsLayoutVersion;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LayoutVersionAbstract extends ContentVersionAbstract
{
    /**
     * @param string|null $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        Param::assertNotEmpty(
            $properties,
            FieldsLayoutVersion::THEME_NAME
        );

        Param::assertNotEmpty(
            $properties,
            FieldsLayoutVersion::NAME
        );

        Param::assertHas(
            $properties,
            FieldsLayoutVersion::HTML,
            PropertyMissing::buildThrower(
                FieldsLayoutVersion::HTML,
                $properties,
                get_class($this)
            )
        );

        parent::__construct(
            $id,
            $properties,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }

    /**
     * @return string
     */
    public function getThemeName(): string
    {
        return $this->findProperty(
            FieldsLayoutVersion::THEME_NAME,
            ''
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->findProperty(
            FieldsLayoutVersion::NAME,
            ''
        );
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return (string)$this->findProperty(
            FieldsLayoutVersion::HTML,
            ''
        );
    }
}
