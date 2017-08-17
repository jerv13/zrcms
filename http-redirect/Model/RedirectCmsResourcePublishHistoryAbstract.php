<?php

namespace Zrcms\HttpRedirect\Redirect\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\PropertiesCmsResourcePublishHistory;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class RedirectCmsResourcePublishHistoryAbstract
    extends RedirectCmsResourceAbstract
    implements RedirectCmsResourcePublishHistory
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
        return $this->getProperty(
            PropertiesCmsResourcePublishHistory::ACTION,
            ''
        );
    }
}
