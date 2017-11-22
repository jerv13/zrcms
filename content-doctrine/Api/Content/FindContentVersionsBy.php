<?php

namespace Zrcms\ContentDoctrine\Api\Content;

use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentDoctrine\Api\ApiAbstractContentVersion;
use Zrcms\ContentDoctrine\Api\BuildBasicContentVersions;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContentVersionsBy
    extends ApiAbstractContentVersion
    implements \Zrcms\Content\Api\Content\FindContentVersionsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return ContentVersion[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array
    {
        $repository = $this->entityManager->getRepository(
            $this->entityClassContentVersion
        );

        $entities = $repository->findBy(
            $criteria,
            $orderBy,
            $limit,
            $offset
        );

        return BuildBasicContentVersions::invoke(
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $entities,
            $this->contentVersionSyncToProperties
        );
    }
}
