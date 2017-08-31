<?php

namespace Zrcms\Content\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Param\Param;

/**
 * A history record of the state of
 *
 * @author James Jervis - https://github.com/jerv13
 */
abstract class CmsResourcePublishHistoryAbstract
    extends CmsResourceAbstract
    implements CmsResourcePublishHistory
{
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

        Param::assertHas(
            $properties,
            PropertiesCmsResourcePublishHistory::ACTION,
            PropertyMissingException::build(
                PropertiesCmsResourcePublishHistory::ACTION,
                $properties,
                get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            PropertiesCmsResourcePublishHistory::CMS_RESOURCE_ID,
            PropertyMissingException::build(
                PropertiesCmsResourcePublishHistory::CMS_RESOURCE_ID,
                $properties,
                get_class($this)
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
    public function getCmsResourceId(): string
    {
        return $this->getProperty(
            PropertiesCmsResourcePublishHistory::ACTION,
            ''
        );
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->getProperty(
            PropertiesCmsResourcePublishHistory::CMS_RESOURCE_ID,
            ''
        );
    }
}
