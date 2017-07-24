<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Block\Model;

use Zrcms\ContentCore\Block\Model\BlockVersion;
use Zrcms\ContentCore\Block\Model\BlockVersionAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BlockVersionEntity extends BlockVersionAbstract implements BlockVersion
{
    public function __construct(
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        $this->createdDate = Param::getRequired(
            $properties,
            PropertiesBlockVersionEntity::CREATED_BY_USER_ID
        );

        parent::__construct($properties, $createdByUserId, $createdReason);
    }
}
