<?php

namespace Zrcms\Core\BlockInstance\Model;

use Zrcms\ContentVersionControl\Model\ContentAbstract;

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
     * @param string $uri
     * @param string $sourceUri
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     * @param string $blockName
     * @param array  $config
     * @param array  $layoutProperties
     */
    public function __construct(
        string $uri,
        string $sourceUri,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        string $blockName,
        array $config,
        array $layoutProperties
    ) {
        $this->blockName = $blockName;
        $this->config = $config;
        $this->layoutProperties = $layoutProperties;

        parent::__construct(
            $uri,
            $sourceUri,
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return mixed
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
        if (array_key_exists($name, $this->layoutProperties)) {
            return $this->layoutProperties[$name];
        }

        return $default;
    }
}
