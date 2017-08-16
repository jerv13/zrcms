<?php

namespace Zrcms\ContentDoctrine\Api;

use Zrcms\Content\Model\CmsResourceVersion;

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
     *
     * @return CmsResourceVersion|null
     * @throws \Exception
     */
    protected function newBasicCmsResourceVersion(
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        string $classCmsResourceVersionBasic,
        array $result
    ) {
        if (empty($result)) {
            return null;
        }

        if (!is_a($classCmsResourceVersionBasic, CmsResourceVersion::class, true)) {
            throw new \Exception(
                'Class basic must be of type: ' . CmsResourceVersion::class
            );
        }

        $cmsResource = $this->newBasicCmsResource(
            $entityClassCmsResource,
            $classCmsResourceBasic,
            $result[0]
        );

        $contentVersion = $this->newBasicContentVersion(
            $entityClassContentVersion,
            $classContentVersionBasic,
            $result[1]
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
     *
     * @return array
     */
    protected function newBasicCmsResourceVersions(
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        string $classCmsResourceVersionBasic,
        array $results
    ) {
        $basics = [];

        $index = 0;
        $count = count($results);

        while ($index <= ($count-1)) {
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
                $result
            );
            $index = $index + 2;
        }

        return $basics;
    }
}
