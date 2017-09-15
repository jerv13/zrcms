<?php

namespace Zrcms\ContentDoctrine\Entity;

use Zrcms\Content\Model\Properties;
use Zrcms\Content\Model\Trackable;

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
