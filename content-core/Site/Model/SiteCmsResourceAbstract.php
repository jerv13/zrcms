<?php

namespace Zrcms\ContentCore\Site\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\CmsResourceAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class SiteCmsResourceAbstract extends CmsResourceAbstract implements SiteCmsResource
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

        Param::assertHas(
            $properties,
            PropertiesSiteCmsResource::HOST,
            new PropertyMissingException(
                'Required property (' . PropertiesSiteCmsResource::HOST . ') is missing in: ' . get_class($this)
                . get_class($this)
            )
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->getProperty(
            PropertiesSiteCmsResource::HOST,
            ''
        );
    }
}
