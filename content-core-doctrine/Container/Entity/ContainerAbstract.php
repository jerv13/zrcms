<?php

namespace Zrcms\ContentCoreDoctrine\Container\Entity;

use Zrcms\ContentCore\Block\Model\BlockVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerAbstract extends \Zrcms\ContentCore\Container\Model\ContainerAbstract
{
    /**
     * @var BlockVersion[]
     */
    protected $blockVersions = [];

    /**
     * @param array $blockVersions
     *
     * @return void
     */
    public function setBlockVersions(array $blockVersions)
    {
        $this->blockVersions = $blockVersions;
    }


    /**
     * @return array
     */
    public function getBlockVersions(): array
    {
        return $this->blockVersions;
    }

    /**
     * @param int  $id ,
     * @param null $default
     *
     * @return BlockVersion
     */
    public function getBlockVersion(int $id, $default = null): BlockVersion
    {
        if (array_key_exists($id, $this->blockVersions)) {
            return $this->blockVersions[$id];
        }

        return $default;
    }
}
