<?php

namespace Zrcms\ContentCore\Block\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\ContentVersionAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class BlockVersionAbstract extends ContentVersionAbstract implements BlockVersion
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
            PropertiesBlockVersion::BLOCK_COMPONENT_NAME,
            PropertyMissingException::build(
                PropertiesBlockVersion::BLOCK_COMPONENT_NAME,
                $properties,
                get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            PropertiesBlockVersion::LAYOUT_PROPERTIES,
            PropertyMissingException::build(
                PropertiesBlockVersion::LAYOUT_PROPERTIES,
                $properties,
                get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            PropertiesBlockVersion::CONTAINER_VERSION_ID,
            PropertyMissingException::build(
                PropertiesBlockVersion::CONTAINER_VERSION_ID,
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
    public function getBlockComponentName(): string
    {
        return $this->getProperty(
            PropertiesBlockVersion::BLOCK_COMPONENT_NAME,
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
            PropertiesBlockVersion::CONFIG,
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
            PropertiesBlockVersion::LAYOUT_PROPERTIES,
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
            PropertyMissingException::build(
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
            PropertiesBlockVersion::CONTAINER_VERSION_ID,
            ''
        );
    }
}
