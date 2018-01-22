<?php

namespace Zrcms\CoreApplicationDoctrine\Api\CmsResourceHistory;

use Zrcms\Core\Api\CmsResourceHistory\FindCmsResourceHistory as CoreFind;
use Zrcms\CoreApplicationDoctrine\Api\ApiAbstractCmsResourceHistory;
use Zrcms\CoreApplicationDoctrine\Api\BuildBasicCmsResourceHistory;
use Zrcms\CoreApplicationDoctrine\Entity\CmsResourceHistoryEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindCmsResourceHistory extends ApiAbstractCmsResourceHistory implements CoreFind
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return null|\Zrcms\Core\Model\CmsResourceHistory
     * @throws \Exception
     */
    public function __invoke(
        string $id,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(
            $this->entityClassCmsResourceHistory
        );

        /** @var CmsResourceHistoryEntity $entity */
        $entity = $repository->find($id);

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
