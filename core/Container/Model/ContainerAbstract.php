<?php

namespace Zrcms\Core\Container\Model;

use Zrcms\Content\Model\ContentAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerAbstract extends ContentAbstract implements Container
{
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
     * @return array
     */
    public function getBlockInstances(): array
    {
        return $this->blockInstances;
    }
}
