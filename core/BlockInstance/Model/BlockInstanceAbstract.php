<?php

namespace Zrcms\Core\BlockInstance\Model;

use Zrcms\Content\Model\ContentAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class BlockInstanceAbstract extends ContentAbstract implements BlockInstance
{
    /**
     * @var string
     */
    protected $blockName;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var array
     */
    protected $layoutProperties = [];

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
        $this->blockName = Param::getRequired(
            $properties,
            BlockInstanceProperties::BLOCK_NAME
        );

        $this->config = Param::get(
            $properties,
            BlockInstanceProperties::CONFIG,
            []
        );

        $this->layoutProperties = Param::getRequired(
            $properties,
            BlockInstanceProperties::LAYOUT_PROPERTIES
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
    public function getBlockName(): string
    {
        return $this->blockName;
    }

    /**
     * @return array The instance config for this block instance.
     * This is what admins can edit in the CMS
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param string $blockName
     * @param null   $default
     *
     * @return mixed
     */
    public function getConfigValue(string $blockName, $default = null)
    {
        if (array_key_exists($blockName, $this->config)) {
            return $this->config[$blockName];
        }

        return $default;
    }

    /**
     * @return array
     */
    public function getLayoutProperties(): array
    {
        return $this->layoutProperties;
    }

    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function getLayoutProperty(string $name, $default = null)
    {
        return Param::get($this->layoutProperties, $name, $default);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getRequiredLayoutProperty(string $name)
    {
        return Param::getRequired($this->layoutProperties, $name);
    }
}
