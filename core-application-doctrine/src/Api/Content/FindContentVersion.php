<?php

namespace Zrcms\CoreApplicationDoctrine\Api\Content;

use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreApplicationDoctrine\Api\ApiAbstractContentVersion;
use Zrcms\CoreApplicationDoctrine\Api\BuildBasicContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContentVersion
    extends ApiAbstractContentVersion
    implements \Zrcms\Core\Api\Content\FindContentVersion
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
