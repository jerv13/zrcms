<?php

namespace Zrcms\Core\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Component extends Immutable, Properties, Trackable
{
    /**
     * @param string $type
     * @param string $name
     * @param string $configUri
     * @param string $moduleDirectory
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     * @param null   $createdDate
     */
    public function __construct(
        string $type,
        string $name,
        string $configUri,
        string $moduleDirectory,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    );

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * Location the config came from
     *
     * @return string
     */
    public function getConfigUri(): string;

    /**
     * Component source code directory
     *
     * @return string
     */
    public function getModuleDirectory(): string;
}
