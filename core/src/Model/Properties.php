<?php

namespace Zrcms\Core\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Properties
{
    const NAME_PROPERTIES = 'properties';

    /**
     * @return array
     */
    public function getProperties(): array;

    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function findProperty(
        string $name,
        $default = null
    );

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasProperty(
        string $name
    ): bool;

    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function findDefaultIfEmptyProperty(
        string $name,
        $default = null
    );
}
