<?php

namespace Zrcms\Core\Container\Model;

use Zrcms\Core\BlockInstance\Model\BlockInstance;
use Zrcms\Tracking\Model\TrackableTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerAbstract
{
    use TrackableTrait;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * @var array
     */
    protected $blockInstances = [];

    /**
     * @param string $uri
     * @param array  $properties
     * @param array  $blockInstances
     * @param string $createdByUserId
     * @param string $createdReason
     * @param string $trackingId
     */
    public function __construct(
        string $uri,
        array $properties,
        array $blockInstances,
        string $createdByUserId,
        string $createdReason,
        string $trackingId
    ) {
        // if has id it is immutable
        if (!empty($this->uri)) {
            return;
        }

        $this->uri = $uri;
        $this->properties = $properties;
        $this->blockInstances = $blockInstances;
        $this->setCreatedData(
            $createdByUserId,
            $createdReason,
            $trackingId
        );
    }

    /**
     * @return mixed
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function getProperty(string $name, $default = null)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        return $default;
    }

    /**
     * @return array
     */
    public function getBlockInstances(): array
    {
        return $this->blockInstances;
    }

    /**
     * @param int  $id ,
     * @param null $default
     *
     * @return BlockInstance
     */
    public function getBlockInstance(int $id, $default = null): BlockInstance
    {
        if (array_key_exists($id, $this->blockInstances)) {
            return $this->blockInstances[$id];
        }

        return $default;
    }
}
