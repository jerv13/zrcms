<?php

namespace Zrcms\CoreDoctrine\Uid\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class Uid implements \Zrcms\Core\Uid\Model\Uid
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $uid;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->uid;
    }
}
