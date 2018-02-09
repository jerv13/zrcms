<?php

namespace Zrcms\CoreBlock\Model;

use Zrcms\Core\Exception\PropertyMissing;
use Zrcms\Core\Model\ContentVersionAbstract;
use Zrcms\CoreBlock\Fields\FieldsBlockVersion;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class BlockVersionAbstract extends ContentVersionAbstract
{
    /**
     * @param        $id
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     * @param null   $createdDate
     *
     * @throws \Exception
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyMissing
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        Property::assertHas(
            $properties,
            FieldsBlockVersion::BLOCK_COMPONENT_NAME,
            get_class($this)
        );

        Property::assertHas(
            $properties,
            FieldsBlockVersion::LAYOUT_PROPERTIES,
            get_class($this)
        );

        Property::assertHas(
            $properties,
            FieldsBlockVersion::CONTAINER_VERSION_ID,
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
    public function getBlockComponentName(): string
    {
        return $this->findProperty(
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
        return $this->findProperty(
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

        return Property::get(
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
        return $this->findProperty(
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

        return Property::get(
            $layoutProperties,
            $name,
            $default
        );
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws \Exception
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyMissing
     */
    public function getRequiredLayoutProperty(string $name)
    {
        $layoutProperties = $this->getLayoutProperties();

        return Property::getRequired(
            $layoutProperties,
            $name,
            get_class($this)
        );
    }

    /**
     * @return string|null
     */
    public function getContainerVersionId(): string
    {
        return $this->findProperty(
            FieldsBlockVersion::CONTAINER_VERSION_ID,
            ''
        );
    }
}
