<?php

namespace Zrcms\ContentDoctrine\Entity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Entity
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @param array $properties
     *
     * @return void
     */
    public function updateProperties(
        array $properties
    );
}
