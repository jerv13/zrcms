<?php

namespace Zrcms\ContentCore\Site\Model;

use Zrcms\Content\Exception\ContentVersionNotExistsException;
use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\CmsResourceAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class SiteCmsResourceAbstract extends CmsResourceAbstract
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
            PropertyMissingException::build(
                PropertiesSiteCmsResource::HOST,
                $properties,
                get_class($this)
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

    /**
     * @param $contentVersion
     *
     * @return void
     * @throws ContentVersionNotExistsException
     */
    protected function assertValidContentVersion($contentVersion)
    {
        if (!$contentVersion instanceof SiteVersion) {
            throw new ContentVersionNotExistsException(
                'Missing required: ' . PropertiesSiteCmsResource::CONTENT_VERSION
            );
        }
    }
}
