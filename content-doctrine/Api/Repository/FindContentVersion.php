<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentDoctrine\Api\ApiAbstractContentVersion;
use Zrcms\ContentDoctrine\Api\BuildBasicContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContentVersion
    extends ApiAbstractContentVersion
    implements \Zrcms\Content\Api\Repository\FindContentVersion
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return ContentVersion|null
     */
    public function __invoke(
        string $id,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(
            $this->entityClassContentVersion
        );

        $entity = $repository->find((int)$id);

        return BuildBasicContentVersion::invoke(
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $entity,
            $this->contentVersionSyncToProperties
        );
    }
}
