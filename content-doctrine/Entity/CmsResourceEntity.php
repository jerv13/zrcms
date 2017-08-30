<?php

namespace Zrcms\ContentDoctrine\Entity;

use Zrcms\Content\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResourceEntity extends CmsResource, Entity
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
