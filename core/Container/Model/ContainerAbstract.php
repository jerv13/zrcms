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
    protected $uid;

    /**
     * <Unique ID>
     *
     * @var string
     */
    protected $uri;

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * @param string $uid
     * @param string $uri
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        string $uid,
        string $uri,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        // if has id it is immutable
        if (!empty($this->uid)) {
            return;
        }

        $this->uid = $uid;
        $this->uri = $uri;
        $this->properties = $properties;
        $this->setCreatedData(
            $createdByUserId,
            $createdReason
        );
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
}
