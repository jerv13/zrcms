<?php

namespace Zrcms\CoreApplicationDoctrine\Api\CmsResourceHistory;

use Zrcms\Core\Api\CmsResourceHistory\FindLastCmsResourceHistory as FindLast;
use Zrcms\CoreApplicationDoctrine\Api\ApiAbstractCmsResourceHistory;
use Zrcms\CoreApplicationDoctrine\Api\BuildBasicCmsResourceHistory;
use Zrcms\CoreApplicationDoctrine\Entity\CmsResourceHistoryEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindLastCmsResourceHistory extends ApiAbstractCmsResourceHistory implements FindLast
{
    /**
     * @param string $cmsResourceId
     * @param array  $options
     *
     * @return null|\Zrcms\Core\Model\CmsResourceHistory
     * @throws \Exception
     */
    public function __invoke(
        string $cmsResourceId,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(
            $this->entityClassCmsResourceHistory
        );

        /** @var CmsResourceHistoryEntity[] $entities */
        $entities = $repository->findBy(
            ['cmsResourceId' => $cmsResourceId],
            ['createdDate' => 'DESC'],
            1
        );

        if (empty($entities)) {
            return null;
        }

        $entity = $entities[0];

        return BuildBasicCmsResourceHistory::invoke(
            $this->entityClassCmsResourceHistory,
            $this->classCmsResourceHistoryBasic,
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $entity
        );
    }
}
