<?php

namespace Rcms\Core\Container\Model;

use Rcms\Core\BlockInstance\Model\BlockInstance;
use Rcms\Core\Tracking\Model\Trackable;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Container extends Trackable
{
    /**
     * Example:
     * @return mixed
     */
    public function getUrl(): string;

    /**
     * @return array
     */
    public function getProperties(): array;

    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function getProperty(string $name, $default = null);

    /**
     * @return array
     */
    public function getBlockInstances(): array;

    /**
     * @param int  $id ,
     * @param null $default
     *
     * @return BlockInstance
     */
    public function getBlockInstance(int $id, $default = null): BlockInstance;
}
