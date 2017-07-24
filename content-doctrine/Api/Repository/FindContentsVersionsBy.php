<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentDoctrine\Api\ApiAbstractContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContentVersionsBy
    extends ApiAbstractContentVersion
    implements \Zrcms\Content\Api\Repository\FindContentVersionsBy
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
            $this->entityClass
        );

        return $repository->findBy(
            $criteria,
            $orderBy,
            $limit,
            $offset
        );
    }
}
