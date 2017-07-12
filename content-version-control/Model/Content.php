<?php

namespace Zrcms\ContentVersionControl\Model;

use Zrcms\ContentVersionControl\Exception\PropertyMissingException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Content extends Trackable
{
    /**
     * <identifier>
     *
     * @return string
     */
    public function getUri(): string;

    /**
     * The URI of the content this was created from
     * For tracking URI changes and copied content
     *
     * @return string
     */
    public function getSourceUri(): string;

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

    /**
     * @param string $name
     *
     * @return mixed
     * @throws PropertyMissingException
     */
    public function getPropertyRequired(string $name);
}
