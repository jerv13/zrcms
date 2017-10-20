<?php

namespace Zrcms\ContentCore\Site\Model;

use Zrcms\Content\Exception\ContentVersionInvalid;
use Zrcms\Content\Exception\PropertyMissing;
use Zrcms\Content\Model\CmsResourceAbstract;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Site\Fields\FieldsSiteCmsResource;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class SiteCmsResourceAbstract extends CmsResourceAbstract
{
    /**
     * @param string|null    $id
     * @param bool           $published
     * @param ContentVersion $contentVersion
     * @param array          $properties
     * @param string         $createdByUserId
     * @param string         $createdReason
     */
    public function __construct(
        $id,
        bool $published,
        ContentVersion $contentVersion,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        Param::assertHas(
            $properties,
            FieldsSiteCmsResource::HOST,
            PropertyMissing::buildThrower(
                FieldsSiteCmsResource::HOST,
                $properties,
                get_class($this)
            )
        );

        parent::__construct(
            $id,
            $published,
            $contentVersion,
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
            FieldsSiteCmsResource::HOST,
            ''
        );
    }

    /**
     * @param $contentVersion
     *
     * @return void
     * @throws ContentVersionInvalid
     */
    protected function assertValidContentVersion($contentVersion)
    {
        if (!$contentVersion instanceof SiteVersion) {
            throw new ContentVersionInvalid(
                'ContentVersion must be instance of: ' . SiteVersion::class
                . ' got: ' . var_export($contentVersion, true)
                . ' for: ' . get_class($this)
            );
        }
    }
}
