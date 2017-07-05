<?php

namespace Rcms\Core\Page\Model;

use Rcms\Core\BlockInstance\Model\BlockInstance;
use Rcms\Core\Tracking\Model\Tracking;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Page extends Tracking
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return int
     */
    public function getSiteId();

    /**
     * @return mixed
     */
    public function getName(): string;

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
