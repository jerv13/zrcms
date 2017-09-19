<?php

namespace Zrcms\ContentCore\Theme\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LayoutComponentBasic extends LayoutComponentAbstract implements LayoutComponent
{
    /**
     * @param string $classification
     * @param string $name
     * @param string $configLocation
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        string $classification,
        string $name,
        string $configLocation,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        parent::__construct(
            $classification,
            $name,
            $configLocation,
            $properties,
            $createdByUserId,
            $createdReason
        );
    }
}
