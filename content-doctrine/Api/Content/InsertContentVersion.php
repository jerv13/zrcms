<?php

namespace Zrcms\ContentDoctrine\Api\Content;

use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentDoctrine\Api\ApiAbstractContentVersion;
use Zrcms\ContentDoctrine\Api\BuildBasicContentVersion;
use Zrcms\ContentDoctrine\Entity\ContentEntity;
use Zrcms\ContentDoctrine\Exception\IdMustBeEmptyException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertContentVersion
    extends ApiAbstractContentVersion
    implements \Zrcms\Content\Api\Content\InsertContentVersion
{
    /**
     * @param ContentVersion $contentVersion
     * @param array          $options
     *
     * @return ContentVersion
     * @throws IdMustBeEmptyException
     */
    public function __invoke(
        ContentVersion $contentVersion,
        array $options = []
    ): ContentVersion
    {
        /** @var ContentEntity::class $contentVersionEntityClass */
        $contentVersionEntityClass = $this->entityClassContentVersion;

        if (!empty($contentVersion->getId())) {
            throw new IdMustBeEmptyException(
                "ID may not be set on create for {$contentVersionEntityClass} with id "
                . $contentVersion->getId()
            );
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
