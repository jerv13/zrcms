<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Block\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\ContentCore\Block\Model\BlockVersion;
use Zrcms\ContentCore\Block\Model\BlockVersionAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BlockVersionEntity extends BlockVersionAbstract implements BlockVersion
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
        // @todo is this right?
        $this->createdDate = Param::getRequired(
            $properties,
            PropertiesBlockVersionEntity::CREATED_DATE,
            new PropertyMissingException(
                'Required property (' . PropertiesBlockVersionEntity::CREATED_DATE . ') is missing in: '
                . get_class($this)
            )
        );

        // Id is required to preserve interface and for caching
        Param::assertHas(
            $properties,
            PropertiesBlockVersionEntity::ID,
            new PropertyMissingException(
                'Required property (' . PropertiesBlockVersionEntity::ID . ') is missing in: '
                . get_class($this)
            )
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }
}
