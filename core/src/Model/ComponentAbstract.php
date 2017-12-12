<?php

namespace Zrcms\Core\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ComponentAbstract
{
    use ImmutableTrait;
    use PropertiesTrait;
    use TrackableTrait;

    protected $type;
    protected $name;
    protected $configUri;
    protected $moduleDirectory;
    protected $properties = [];

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
    ) {
        // Enforce immutability
        if (!$this->isNew()) {
            return;
        }
        $this->new = false;

        $this->type = $type;
        $this->name = $name;
        $this->configUri = $configUri;
        $this->moduleDirectory = $moduleDirectory;
        $this->properties = $properties;

        $this->setCreatedData(
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getConfigUri(): string
    {
        return $this->configUri;
    }

    /**
     * Component source code directory
     *
     * @return string
     */
    public function getModuleDirectory(): string
    {
        return $this->moduleDirectory;
    }
}
