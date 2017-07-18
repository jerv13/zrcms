<?php

namespace Zrcms\Core\Container\Model;

use Zrcms\Content\Model\ContentAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerAbstract extends ContentAbstract implements Container
{
    /**
     * @var array|mixed
     */
    protected $blockInstances = [];

    /**
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        $this->id = Param::getRequired(
            $properties,
            ContainerProperties::PATH
        );

        $this->blockInstances = Param::getRequired(
            $properties,
            ContainerProperties::BLOCK_INSTANCES
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * <identifier>
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->getId();
    }

    /**
     * @return array
     */
    public function getBlockInstances(): array
    {
        return $this->blockInstances;
    }
}
