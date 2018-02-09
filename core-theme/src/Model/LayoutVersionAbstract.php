<?php

namespace Zrcms\CoreTheme\Model;

use Zrcms\Core\Exception\PropertyMissing;
use Zrcms\Core\Model\ContentVersionAbstract;
use Zrcms\CoreTheme\Fields\FieldsLayoutVersion;
use Reliv\ArrayProperties\Property;

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
     *
     * @throws \Exception
     * @throws \Throwable
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyException
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyMissing
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        Property::assertNotEmpty(
            $properties,
            FieldsLayoutVersion::THEME_NAME
        );

        Property::assertNotEmpty(
            $properties,
            FieldsLayoutVersion::NAME
        );

        Property::assertHas(
            $properties,
            FieldsLayoutVersion::HTML,
            get_class($this)
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
