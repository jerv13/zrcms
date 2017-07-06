<?php

namespace Rcms\Core\Uid\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class Uid implements \Rcms\Core\Uid\Model\Uid
{
    /**
     * @var int Auto-Incremented Primary Key
     *
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $uid;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->uid;
    }
}
