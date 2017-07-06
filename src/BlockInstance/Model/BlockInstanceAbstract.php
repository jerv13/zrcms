<?php

namespace Rcms\Core\BlockInstance\Model;

use Rcms\Core\Tracking\Model\TrackableTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class BlockInstanceAbstract implements BlockInstance
{
    use TrackableTrait;

    /**
     * @var
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param        $id
     * @param string $name
     * @param array  $config
     * @param array  $data
     */
    public function __construct(
        $id,
        string $name,
        array $config,
        array $data
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->config = $config;
        $this->data = $data;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName(): string
    {
        return $this->name;
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
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function getDataValue(string $name, $default = null)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        return $default;
    }
}
