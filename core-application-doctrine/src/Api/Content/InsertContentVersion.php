<?php

namespace Zrcms\CoreApplicationDoctrine\Api\Content;

use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreApplication\Api\GetGuidV4;
use Zrcms\CoreApplicationDoctrine\Api\ApiAbstractContentVersion;
use Zrcms\CoreApplicationDoctrine\Api\BuildBasicContentVersion;
use Zrcms\CoreApplicationDoctrine\Entity\ContentEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertContentVersion extends ApiAbstractContentVersion implements \Zrcms\Core\Api\Content\InsertContentVersion
{
    /**
     * @param ContentVersion $contentVersion
     * @param array          $options
     *
     * @return ContentVersion
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    public function __invoke(
        ContentVersion $contentVersion,
        array $options = []
    ): ContentVersion {
        /** @var ContentEntity::class $contentVersionEntityClass */
        $contentVersionEntityClass = $this->entityClassContentVersion;

        $id = $contentVersion->getId();

        if (empty($id)) {
            $id = GetGuidV4::invoke();
        }

        $newContentVersion = new $contentVersionEntityClass(
            $contentVersion->getId(),
            $contentVersion->getProperties(),
            $contentVersion->getCreatedByUserId(),
            $contentVersion->getCreatedReason(),
            $contentVersion->getCreatedDate()
        );

        $this->entityManager->persist($newContentVersion);
        $this->entityManager->flush($newContentVersion);

        return BuildBasicContentVersion::invoke(
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $newContentVersion,
            $this->contentVersionSyncToProperties
        );
    }
}
