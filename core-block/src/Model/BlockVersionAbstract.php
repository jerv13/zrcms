<?php

namespace Zrcms\CoreBlock\Model;

use Zrcms\Core\Exception\PropertyMissing;
use Zrcms\Core\Model\ContentVersionAbstract;
use Zrcms\CoreBlock\Fields\FieldsBlockVersion;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class BlockVersionAbstract extends ContentVersionAbstract
{
    /**
     * @param null|string $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param null        $createdDate
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
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
        return $this->findProperty(
            FieldsBlockVersion::CONTAINER_VERSION_ID,
            ''
        );
    }
}
