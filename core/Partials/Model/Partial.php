<?php

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Partial
{
    /**
     * Unique Name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Service name (service must be callable)
     *
     * @return string
     */
    public function getRenderer(): string;

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
    public function getProperty(string $name, $default = null);
}
