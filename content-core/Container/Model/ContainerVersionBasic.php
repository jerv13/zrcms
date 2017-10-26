<?php

namespace Zrcms\ContentCore\Container\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ContainerVersionBasic extends ContainerVersionAbstract implements ContainerVersion
{
    /**
     * @param null|string $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        parent::__construct(
            $id,
            $properties,
            $createdByUserId,
            $createdReason
        );
    }
}
