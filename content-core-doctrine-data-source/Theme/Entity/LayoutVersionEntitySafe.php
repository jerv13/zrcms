<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Entity;

use Zrcms\ContentCore\Theme\Model\PropertiesLayoutVersion;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LayoutVersionEntitySafe extends LayoutVersionEntity
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
    ) {

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );

        $this->id = Param::getString(
            $properties,
            PropertiesLayoutVersion::ID,
            ''
        );
    }
}
