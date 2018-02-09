<?php

namespace Zrcms\CoreBlock\Model;

use Zrcms\Core\Model\ContentAbstract;
use Zrcms\CoreBlock\Fields\FieldsBlock;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class BlockAbstract extends ContentAbstract implements Block
{
    /**
     * @param array       $properties
     * @param null|string $id
     *
     * @throws \Exception
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyMissing
     */
    public function __construct(
        array $properties,
        $id = null
    ) {
        Property::assertHas(
            $properties,
            FieldsBlock::BLOCK_COMPONENT_NAME,
            get_class($this)
        );

        Property::assertHas(
            $properties,
            FieldsBlock::LAYOUT_PROPERTIES,
            get_class($this)
        );

        parent::__construct(
            $properties,
            $id
        );
    }

    /**
     * @return string
     */
    public function getBlockComponentName(): string
    {
        return $this->findProperty(
            FieldsBlock::BLOCK_COMPONENT_NAME,
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
            FieldsBlock::CONFIG,
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
            FieldsBlock::LAYOUT_PROPERTIES,
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
}
