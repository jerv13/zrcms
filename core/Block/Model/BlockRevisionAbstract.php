<?php

namespace Zrcms\Core\Block\Model;

use Zrcms\Content\Model\ContentRevisionAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class BlockRevisionAbstract extends ContentRevisionAbstract implements BlockRevision
{
    /**
     * @var string
     */
    protected $containerId;

    /**
     * @var string
     */
    protected $blockComponentName;

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
        $this->containerId = Param::getRequired(
            $properties,
            BlockRevisionProperties::BLOCK_COMPONENT_NAME
        );

        $this->blockComponentName = Param::getRequired(
            $properties,
            BlockRevisionProperties::BLOCK_COMPONENT_NAME
        );

        $this->id = Param::get(
            $properties,
            BlockRevisionProperties::ID
        );

        $this->config = Param::get(
            $properties,
            BlockRevisionProperties::CONFIG,
            []
        );

        $this->layoutProperties = Param::getRequired(
            $properties,
            BlockRevisionProperties::LAYOUT_PROPERTIES
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
    public function getContainerId(): string
    {
        return $this->containerId;
    }

    /**
     * @return string
     */
    public function getBlockComponentName(): string
    {
        return $this->blockComponentName;
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
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function getConfigValue(string $name, $default = null)
    {
        if (array_key_exists($name, $this->config)) {
            return $this->config[$name];
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
