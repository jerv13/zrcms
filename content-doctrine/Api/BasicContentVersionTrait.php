<?php

namespace Zrcms\ContentDoctrine\Api;

use Zrcms\Content\Model\ContentVersion;
use Zrcms\Content\Model\PropertiesContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
trait BasicContentVersionTrait
{
    /**
     * @param string         $entityClassContentVersion
     * @param string         $classContentVersionBasic
     * @param ContentVersion $entity
     *
     * @return ContentVersion
     * @throws \Exception
     */
    protected function newBasicContentVersion(
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        $entity
    ) {
        if (empty($entity)) {
            return null;
        }

        if (!is_a($entityClassContentVersion, ContentVersion::class, true)) {
            throw new \Exception('Entity class must be of type: ' . ContentVersion::class);
        }

        if (!is_a($classContentVersionBasic, ContentVersion::class, true)) {
            throw new \Exception('Class basic must be of type: ' . ContentVersion::class);
        }

        if (!is_a($entity, $entityClassContentVersion)) {
            throw new \Exception('Entity must be of type: ' . $entityClassContentVersion);
        }

        if (!is_a($entity, ContentVersion::class)) {
            throw new \Exception('Entity must be of type: ' . ContentVersion::class);
        }

        $properties = $entity->getProperties();

        // Sync ID back
        $properties[PropertiesContentVersion::ID] = (string)$entity->getId();

        return new $classContentVersionBasic(
            $properties,
            $entity->getCreatedByUserId(),
            $entity->getCreatedReason()
        );
    }

    /**
     * @param string $entityClassContentVersion
     * @param string $classContentVersionBasic
     * @param array  $entities
     *
     * @return ContentVersion[]
     */
    protected function newBasicContentVersions(
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        array $entities
    ) {
        $basics = [];

        foreach ($entities as $entity) {
            $basics[] = $this->newBasicContentVersion(
                $entityClassContentVersion,
                $classContentVersionBasic,
                $entity
            );
        }

        return $basics;
    }
}
