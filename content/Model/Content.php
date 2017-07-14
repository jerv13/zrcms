<?php

namespace Zrcms\Content\Model;

use Zrcms\Content\Exception\PropertyMissingException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Content extends Trackable
{
    /**
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        array $properties,
        string $createdByUserId,
        string $createdReason
    );

    /**
     * @return mixed
     */
    public function getId();

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
