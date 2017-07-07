<?php

namespace Zrcms\Core\Container\Model;

use Zrcms\Core\BlockInstance\Model\BlockInstance;
use Zrcms\Tracking\Model\Trackable;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Container extends Trackable
{
    /**
     * Example:
     * @return mixed
     */
    public function getUri(): string;

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
