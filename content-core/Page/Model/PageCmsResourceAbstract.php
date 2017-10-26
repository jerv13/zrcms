<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Exception\ContentVersionInvalid;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Container\Model\ContainerCmsResourceAbstract;
use Zrcms\ContentCore\Page\Exception\InvalidPathException;
use Zrcms\ContentCore\Page\Fields\FieldsPageCmsResource;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PageCmsResourceAbstract extends ContainerCmsResourceAbstract
{
    /**
     * @param string|null    $id
     * @param bool           $published
     * @param ContentVersion $contentVersion
     * @param array          $properties
     * @param string         $createdByUserId
     * @param string         $createdReason
     *
     * @throws InvalidPathException
     */
    public function __construct(
        $id,
        bool $published,
        ContentVersion $contentVersion,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        $path = Param::getRequired(
            $properties,
            FieldsPageCmsResource::PATH
        );

        if (substr($path, 0, 1) !== "/") {
            throw new InvalidPathException(
                'Path for page must start with /'
                . ' got: ' . $path
            );
        }

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
    public function getSiteCmsResourceId(): string
    {
        return $this->getProperty(
            FieldsPageCmsResource::SITE_CMS_RESOURCE_ID,
            ''
        );
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->getProperty(
            FieldsPageCmsResource::PATH,
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
        if (!$contentVersion instanceof PageVersion) {
            throw new ContentVersionInvalid(
                'ContentVersion must be instance of: ' . PageVersion::class
                . ' got: ' . var_export($contentVersion, true)
                . ' for: ' . get_class($this)
            );
        }
    }
}
