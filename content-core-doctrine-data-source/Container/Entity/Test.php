<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\ORM\Mapping\Entity;
//use Doctrine\ORM\Mapping\Table;
/**
 * @todo THIS WORKED IN A DIFFERENCT FOLDER
 * @todo THIS CAUSED AN ERROR when not importing ORM
 *
 * @ORM\Entity
 * @ORM\Table(name="tttt")
 */
class Test
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $value;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
