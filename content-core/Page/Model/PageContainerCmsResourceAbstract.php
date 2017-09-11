<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Exception\ContentVersionNotExistsException;
use Zrcms\ContentCore\Container\Model\ContainerCmsResourceAbstract;
use Zrcms\ContentCore\Page\Exception\InvalidPathException;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PageContainerCmsResourceAbstract extends ContainerCmsResourceAbstract
{
    /**
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     *
     * @throws InvalidPathException
     */
    public function __construct(
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        $path = Param::getRequired(
            $properties,
            PropertiesPageContainerCmsResource::PATH
        );

        if (substr($path, 0, 1) !== "/") {
            throw new InvalidPathException(
                'Path for page must start with /'
                . ' got: ' . $path
            );
        }

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
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
        if (!$contentVersion instanceof PageContainerVersion) {
            throw new ContentVersionNotExistsException(
                'Missing required: ' . PropertiesPageContainerCmsResource::CONTENT_VERSION
            );
        }
    }
}
