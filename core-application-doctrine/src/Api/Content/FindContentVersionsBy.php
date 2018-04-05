<?php

namespace Zrcms\CoreApplicationDoctrine\Api\Content;

use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreApplicationDoctrine\Api\ApiAbstractContentVersion;
use Zrcms\CoreApplicationDoctrine\Api\BuildBasicContentVersions;
use Zrcms\CoreApplicationDoctrine\Api\MutateFieldNames;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContentVersionsBy extends ApiAbstractContentVersion implements \Zrcms\Core\Api\Content\FindContentVersionsBy
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
    ): array {
        $repository = $this->entityManager->getRepository(
            $this->entityClassContentVersion
        );

        $criteria = MutateFieldNames::invoke($criteria);
        $orderBy = MutateFieldNames::invoke($orderBy);

        $entities = $repository->findBy(
            $criteria,
            $orderBy,
            $limit,
            $offset
        );

        // @todo Deal with property searches

        return BuildBasicContentVersions::invoke(
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $entities,
            $this->contentVersionSyncToProperties
        );
    }
}
