<?php

namespace Zrcms\CoreApplicationDoctrine\Entity;

use Zrcms\Core\Model\Properties;
use Zrcms\Core\Model\Trackable;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ContentEntity extends Entity, Properties, Trackable
{
    /**
     * @return string
     */
    public function getId(): string;
}
