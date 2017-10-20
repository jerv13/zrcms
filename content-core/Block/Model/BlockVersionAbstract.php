<?php

namespace Zrcms\ContentCore\Block\Model;

use Zrcms\Content\Exception\PropertyMissing;
use Zrcms\Content\Model\ContentVersionAbstract;
use Zrcms\ContentCore\Block\Fields\FieldsBlockVersion;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class BlockVersionAbstract extends ContentVersionAbstract
{
    /**
     * @param string|null $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        Param::assertHas(
            $properties,
            FieldsBlockVersion::BLOCK_COMPONENT_NAME,
            PropertyMissing::buildThrower(
                FieldsBlockVersion::BLOCK_COMPONENT_NAME,
                $properties,
                get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            FieldsBlockVersion::LAYOUT_PROPERTIES,
            PropertyMissing::buildThrower(
                FieldsBlockVersion::LAYOUT_PROPERTIES,
                $properties,
                get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            FieldsBlockVersion::CONTAINER_VERSION_ID,
            PropertyMissing::buildThrower(
                FieldsBlockVersion::CONTAINER_VERSION_ID,
                $properties,
                get_class($this)
            )
        );

        parent::__construct(
            $id,
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getBlockComponentName(): string
    {
        return $this->getProperty(
            FieldsBlockVersion::BLOCK_COMPONENT_NAME,
            ''
        );
    }

    /**
     * @return array The instance config for this block instance.
     * This is what admins can edit in the CMS
     */
    public function getConfig(): array
    {
        return $this->getProperty(
            FieldsBlockVersion::CONFIG,
            []
        );
    }

    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function getConfigValue(string $name, $default = null)
    {
        $config = $this->getConfig();

        return Param::get(
            $config,
            $name,
            $default
        );
    }

    /**
     * @return array
     */
    public function getLayoutProperties(): array
    {
        return $this->getProperty(
            FieldsBlockVersion::LAYOUT_PROPERTIES,
            []
        );
    }

    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function getLayoutProperty(string $name, $default = null)
    {
        $layoutProperties = $this->getLayoutProperties();

        return Param::get(
            $layoutProperties,
            $name,
            $default
        );
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getRequiredLayoutProperty(string $name)
    {
        $layoutProperties = $this->getLayoutProperties();

        return Param::getRequired(
            $layoutProperties,
            $name,
            PropertyMissing::buildThrower(
                $name,
                $layoutProperties,
                get_class($this)
            )
        );
    }

    /**
     * @return string|null
     */
    public function getContainerVersionId(): string
    {
        return $this->getProperty(
            FieldsBlockVersion::CONTAINER_VERSION_ID,
            ''
        );
    }
}
