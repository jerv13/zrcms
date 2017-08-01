<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentDoctrine\Api\ApiAbstractContentVersion;
use Zrcms\ContentDoctrine\Api\BasicContentVersionTrait;
use Zrcms\ContentDoctrine\Exception\IdMustBeEmptyException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertContentVersion
    extends ApiAbstractContentVersion
    implements \Zrcms\Content\Api\Repository\InsertContentVersion
{
    use BasicContentVersionTrait;

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
        /** @var ContentVersion::class $entityClass */
        $entityClass = $this->entityClassContentVersion;

        if (!empty($contentVersion->getId())) {
            throw new IdMustBeEmptyException(
                "ID may not be set on create for {$entityClass} with id " . $contentVersion->getId()
            );
        }

        $newContentVersion = new $entityClass(
            $contentVersion->getProperties(),
            $contentVersion->getCreatedByUserId(),
            $contentVersion->getCreatedReason()
        );

        $this->entityManager->persist($newContentVersion);
        $this->entityManager->flush($newContentVersion);

        return $this->newBasicContentVersion(
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $newContentVersion
        );
    }
}
