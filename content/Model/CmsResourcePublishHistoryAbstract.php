<?php

namespace Zrcms\Content\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Param\Param;

/**
 * A history record of the state of
 *
 * @author James Jervis - https://github.com/jerv13
 */
abstract class CmsResourcePublishHistoryAbstract extends CmsResourceAbstract
{
    /**
     * @var string
     */
    protected $action;

    /**
     * @param array  $properties
     * @param string $publishedByUserId
     * @param string $publishReason
     */
    public function __construct(
        array $properties,
        string $publishedByUserId,
        string $publishReason
    ) {

        $this->action = Param::getRequired(
            $properties,
            PropertiesCmsResourcePublishHistory::ACTION,
            new PropertyMissingException(
                'Required property (' . PropertiesCmsResource::CONTENT_VERSION_ID . ') is missing in: '
                . get_class($this)
            )
        );

        parent::__construct(
            $properties,
            $publishedByUserId,
            $publishReason
        );
    }
}
