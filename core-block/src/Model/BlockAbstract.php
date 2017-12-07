<?php

namespace Zrcms\CoreBlock\Model;

use Zrcms\Core\Exception\PropertyMissing;
use Zrcms\Core\Model\ContentAbstract;
use Zrcms\CoreBlock\Fields\FieldsBlock;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class BlockAbstract extends ContentAbstract implements Block
{
    /**
     * @param array $properties
     * @param null  $id
     */
    public function __construct(
        array $properties,
        $id = null
    ) {
        Param::assertHas(
            $properties,
            FieldsBlock::BLOCK_COMPONENT_NAME,
            PropertyMissing::buildThrower(
                FieldsBlock::BLOCK_COMPONENT_NAME,
                $properties,
                get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            FieldsBlock::LAYOUT_PROPERTIES,
            PropertyMissing::buildThrower(
                FieldsBlock::LAYOUT_PROPERTIES,
                $properties,
                get_class($this)
            )
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
        return $this->getProperty(
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
        return $this->getProperty(
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
}
