<?php

namespace Zrcms\ContentDoctrine\Entity;

use Zrcms\Content\Model\Properties;
use Zrcms\Content\Model\Trackable;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResourceEntity extends Entity, Properties, Trackable
{
    /**
     * Sync array of properties to object properties
     *
     * @param array $properties
     *
     * @return void
     */
    public function updateProperties(
        array $properties
    );
}
