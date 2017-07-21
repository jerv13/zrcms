<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentDoctrine\Api\ApiAbstractCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindCmsResource
    extends ApiAbstractCmsResource
    implements \Zrcms\Content\Api\Repository\FindCmsResource
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return CmsResource|null
     */
    public function __invoke(
        string $id,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(
            $this->entityClass
        );

        return $repository->find($id);
    }
}
