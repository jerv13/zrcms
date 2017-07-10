<?php

namespace Zrcms\Core\BlockInstance\Model;

use Zrcms\Tracking\Model\TrackableTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class BlockInstanceAbstract implements BlockInstance
{
    use TrackableTrait;

    /**
     * @var string
     */
    protected $uid;

    /**
     * <identifier>
     *
     * @var string
     */
    protected $uri;

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
     * @var array
     */
    protected $data = [];

    /**
     * @param string $uid
     * @param string $uri
     * @param string $blockName
     * @param array  $config
     * @param array  $layoutProperties
     * @param array  $data
     */
    public function __construct(
        string $uid,
        string $uri,
        string $blockName,
        array $config,
        array $layoutProperties,
        array $data
    ) {
        $this->uid = $uid;
        $this->uri = $uri;
        $this->blockName = $blockName;
        $this->config = $config;
        $this->layoutProperties = $layoutProperties;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uid;
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
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param string $blockName
     * @param null   $default
     *
     * @return mixed
     */
    public function getDataValue(string $blockName, $default = null)
    {
        if (array_key_exists($blockName, $this->data)) {
            return $this->data[$blockName];
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
     * @param string $blockName
     * @param null   $default
     *
     * @return mixed
     */
    public function getLayoutProperty(string $blockName, $default = null)
    {
        if (array_key_exists($blockName, $this->layoutProperties)) {
            return $this->layoutProperties[$blockName];
        }

        return $default;
    }
}
