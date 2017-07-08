<?php

namespace Zrcms\CountryDoctrine\Country\Entity;

use Zrcms\Uid\Model\Uid;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\Table(
 *     name="zrcms_country_uid"
 * )
 */
class CountryUid implements Uid
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
