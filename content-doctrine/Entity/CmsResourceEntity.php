<?php

namespace Zrcms\ContentDoctrine\Entity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResourceEntity extends Entity
{
    /**
     * @param array $properties
     *
     * @return void
     */
    public function updateProperties(
        array $properties
    );
}
