<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\CmsResourcePublishHistory;
use Zrcms\Content\Model\PropertiesCmsResourcePublishHistory;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerCmsResourcePublishHistoryAbstract
    extends ContainerCmsResourceAbstract
    implements ContainerCmsResourcePublishHistory
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
                'Required property (' . PropertiesCmsResourcePublishHistory::ACTION . ') is missing in: '
                . get_class($this)
            )
        );

        parent::__construct(
            $properties,
            $publishedByUserId,
            $publishReason
        );
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }
}
