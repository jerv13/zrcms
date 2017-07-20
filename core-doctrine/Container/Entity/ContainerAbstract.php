<?php

namespace Zrcms\CoreDoctrine\Container\Entity;

use Zrcms\Core\BlockRevision\Model\BlockRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerAbstract extends \Zrcms\Core\Container\Model\ContainerAbstract
{
    /**
     * @var array [BlockRevision]
     */
    protected $blockRevisions = [];

    /**
     * @param array $blockRevisions
     *
     * @return void
     */
    public function setBlockRevisions(array $blockRevisions)
    {
        $this->blockRevisions = $blockRevisions;
    }


    /**
     * @return array
     */
    public function getBlockRevisions(): array
    {
        return $this->blockRevisions;
    }

    /**
     * @param int  $id ,
     * @param null $default
     *
     * @return BlockRevision
     */
    public function getBlockRevision(int $id, $default = null): BlockRevision
    {
        if (array_key_exists($id, $this->blockRevisions)) {
            return $this->blockRevisions[$id];
        }

        return $default;
    }
}
