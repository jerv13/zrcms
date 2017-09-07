<?php

namespace Zrcms\ContentDoctrine\Api;

use Zrcms\Content\Exception\CmsResourceNotExistsException;
use Zrcms\Content\Exception\ContentVersionNotExistsException;
use Zrcms\Content\Model\CmsResourceVersion;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResourceVersionBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
trait BasicCmsResourceVersionTrait
{
    use BasicCmsResourceTrait;
    use BasicContentVersionTrait;

    /**
     * @param string $entityClassCmsResource
     * @param string $classCmsResourceBasic
     * @param string $entityClassContentVersion
     * @param string $classContentVersionBasic
     * @param string $classCmsResourceVersionBasic
     * @param array  $result
     * @param array  $cmsResourceSyncToProperties
     * @param array  $contentVersionSyncToProperties
     *
     * @return CmsResourceVersion|null
     * @throws CmsResourceNotExistsException
     * @throws ContentVersionNotExistsException
     * @throws \Exception
     */
    protected function newBasicCmsResourceVersion(
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        string $classCmsResourceVersionBasic,
        array $result,
        array $cmsResourceSyncToProperties = [],
        array $contentVersionSyncToProperties = []
    ) {
        if (empty($result)) {
            return null;
        }

        if (!is_a($classCmsResourceVersionBasic, CmsResourceVersion::class, true)) {
            throw new \Exception(
                'Class basic must be of type: ' . CmsResourceVersion::class
            );
        }

        if (empty($result[0])) {
            throw new CmsResourceNotExistsException(
                'CMS Resource does not exist: ' . $entityClassCmsResource
            );
        }

        $cmsResource = $this->newBasicCmsResource(
            $entityClassCmsResource,
            $classCmsResourceBasic,
            $result[0],
            $cmsResourceSyncToProperties
        );

        if (empty($result[1])) {
            throw new ContentVersionNotExistsException(
                'Content version does not exist: ' . $entityClassContentVersion
                . ' for CMS Resource ID: ' . $cmsResource->getId()
                . ' with Content Version ID: ' . $cmsResource->getContentVersionId()
            );
        }

        $contentVersion = $this->newBasicContentVersion(
            $entityClassContentVersion,
            $classContentVersionBasic,
            $result[1],
            $contentVersionSyncToProperties
        );

        return new $classCmsResourceVersionBasic(
            $cmsResource,
            $contentVersion
        );
    }

    /**
     * @param string $entityClassCmsResource
     * @param string $classCmsResourceBasic
     * @param string $entityClassContentVersion
     * @param string $classContentVersionBasic
     * @param string $classCmsResourceVersionBasic
     * @param array  $results
     * @param array  $cmsResourceSyncToProperties
     * @param array  $contentVersionSyncToProperties
     *
     * @return CmsResourceVersion[]
     */
    protected function newBasicCmsResourceVersions(
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        string $classCmsResourceVersionBasic,
        array $results,
        array $cmsResourceSyncToProperties = [],
        array $contentVersionSyncToProperties = []
    ) {
        $basics = [];

        $index = 0;
        $count = count($results);

        while ($index <= ($count - 1)) {
            $result = [
                $results[$index],
                $results[$index + 1],
            ];
            $basics[] = $this->newBasicCmsResourceVersion(
                $entityClassCmsResource,
                $classCmsResourceBasic,
                $entityClassContentVersion,
                $classContentVersionBasic,
                $classCmsResourceVersionBasic,
                $result,
                $cmsResourceSyncToProperties,
                $contentVersionSyncToProperties
            );
            $index = $index + 2;
        }

        return $basics;
    }
}
