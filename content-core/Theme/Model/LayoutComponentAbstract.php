<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Exception\PropertyMissing;
use Zrcms\Content\Model\ComponentAbstract;
use Zrcms\ContentCore\Theme\Fields\FieldsLayoutComponent;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LayoutComponentAbstract extends ComponentAbstract
{
    /**
     * @param string      $category
     * @param string      $name
     * @param string      $configLocation
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     */
    public function __construct(
        string $category,
        string $name,
        string $configLocation,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        Param::assertHas(
            $properties,
            FieldsLayoutComponent::THEME_NAME,
            PropertyMissing::buildThrower(
                FieldsLayoutComponent::THEME_NAME,
                $properties,
                get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            FieldsLayoutComponent::HTML,
            PropertyMissing::buildThrower(
                FieldsLayoutComponent::HTML,
                $properties,
                get_class($this)
            )
        );

        parent::__construct(
            $category,
            $name,
            $configLocation,
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
        return $this->getProperty(
            FieldsLayoutComponent::THEME_NAME,
            ''
        );
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->getProperty(
            FieldsLayoutComponent::HTML,
            ''
        );
    }
}
