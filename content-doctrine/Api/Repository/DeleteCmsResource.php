<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Zrcms\ContentDoctrine\Api\ApiAbstractCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DeleteCmsResource
    extends ApiAbstractCmsResource
    implements \Zrcms\Content\Api\Repository\DeleteCmsResource
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return bool success
     */
    public function __invoke(
        string $id,
        array $options = []
    ): bool
    {
        $repository = $this->entityManager->getRepository(
            $this->entityClass
        );

        $cmsResource = $repository->find($id);

        if (empty($cmsResource)) {
            return false;
        }

        $this->entityManager->remove($cmsResource);
        $this->entityManager->flush($cmsResource);

        return true;
    }
}
