<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentDoctrine\Api\ApiAbstractContentVersion;
use Zrcms\ContentDoctrine\Api\BasicContentVersionTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContentVersionsBy
    extends ApiAbstractContentVersion
    implements \Zrcms\Content\Api\Repository\FindContentVersionsBy
{
    use BasicContentVersionTrait;

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

        return $this->newBasicContentVersions(
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $entities
        );
    }
}
