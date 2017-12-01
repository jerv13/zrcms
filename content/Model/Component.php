<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Component extends Immutable, Properties, Trackable
{
    /**
     * @param string      $category
     * @param string      $name
     * @param string      $configLocation
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     */
    public function __construct(
        string $category,
        string $name,
        string $configLocation,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    );

    /**
     * @return string
     */
    public function getCategory(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * Location the config came from
     *
     * @return string
     */
    public function getConfigLocation(): string ;
}
