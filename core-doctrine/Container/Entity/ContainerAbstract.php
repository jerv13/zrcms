<?php

namespace Zrcms\CoreDoctrine\Container\Entity;

use Zrcms\Core\BlockInstance\Model\BlockInstance;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerAbstract extends \Zrcms\Core\Container\Model\ContainerAbstract
{
    /**
     * @var array [BlockInstance]
     */
    protected $blockInstances = [];

    /**
     * @param array $blockInstances
     *
     * @return void
     */
    public function setBlockInstances(array $blockInstances)
    {
        $this->blockInstances = $blockInstances;
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
