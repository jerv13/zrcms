<?php

namespace Zrcms\CoreApplicationDoctrine\Api\CmsResourceHistory;

use Zrcms\Core\Api\CmsResourceHistory\FindCmsResourceHistoryBy as CoreFindCmsResourceHistoryBy;
use Zrcms\Core\Model\CmsResourceHistory;
use Zrcms\CoreApplicationDoctrine\Api\ApiAbstractCmsResourceHistory;
use Zrcms\CoreApplicationDoctrine\Api\BuildBasicCmsResourceHistoryList;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindCmsResourceHistoryBy extends ApiAbstractCmsResourceHistory implements CoreFindCmsResourceHistoryBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return CmsResourceHistory[]
     * @throws \Exception
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array {
        $repository = $this->entityManager->getRepository(
            $this->entityClassCmsResourceHistory
        );

        $entities = $repository->findBy(
            $criteria,
            $orderBy,
            $limit,
            $offset
        );

        return BuildBasicCmsResourceHistoryList::invoke(
            $this->entityClassCmsResourceHistory,
            $this->classCmsResourceHistoryBasic,
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $entities
        );
    }
}
