<?php

namespace Rcms\Core\Page\Model;

use Rcms\Core\BlockInstance\Model\BlockInstance;
use Rcms\Core\Tracking\Model\TrackingTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class PageAbstract
{
    use TrackingTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $siteId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * @var array
     */
    protected $blockInstances = [];

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
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
        return $this->properties;
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
    public function getBlockInstance(int $id, $default = null)
    {
        if (array_key_exists($id, $this->blockInstances)) {
            return $this->blockInstances[$id];
        }

        return $default;
    }
}
