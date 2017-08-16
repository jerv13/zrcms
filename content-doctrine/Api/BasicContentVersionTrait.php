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
     * @param string              $entityClassContentVersion
     * @param string              $classContentVersionBasic
     * @param ContentVersion|null $entity
     * @param array               $contentVersionSyncToProperties
     *
     * @return ContentVersion|null
     * @throws \Exception
     */
    protected function newBasicContentVersion(
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        $entity,
        array $contentVersionSyncToProperties = []
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

        $properties = $this->syncContentVersionProperties(
            $entity,
            $contentVersionSyncToProperties
        );

        return new $classContentVersionBasic(
            $properties,
            $entity->getCreatedByUserId(),
            $entity->getCreatedReason()
        );
    }

    /**
     * @param ContentVersion $entity
     * @param array          $contentVersionSyncToProperties
     *
     * @return array
     * @throws \Exception
     */
    protected function syncContentVersionProperties(
        ContentVersion $entity,
        array $contentVersionSyncToProperties
    ) {
        // always sync
        if (!array_key_exists(PropertiesContentVersion::ID, $contentVersionSyncToProperties)) {
            $contentVersionSyncToProperties[] = PropertiesContentVersion::ID;
        }

        $properties = $entity->getProperties();

        foreach ($contentVersionSyncToProperties as $syncToProperty) {
            $method = 'get' . ucfirst($syncToProperty);
            if (!method_exists($entity, $method)) {
                throw new \Exception(
                    'Can not sync property: ' . $syncToProperty
                    . ' for ' . get_class($entity)
                );
            }

            $properties[$syncToProperty] = $entity->$method();
        }

        return $properties;
    }

    /**
     * @param string $entityClassContentVersion
     * @param string $classContentVersionBasic
     * @param array  $entities
     * @param array  $contentVersionSyncToProperties
     *
     * @return ContentVersion[]
     */
    protected function newBasicContentVersions(
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        array $entities,
        array $contentVersionSyncToProperties = []
    ) {
        $basics = [];

        foreach ($entities as $entity) {
            $basics[] = $this->newBasicContentVersion(
                $entityClassContentVersion,
                $classContentVersionBasic,
                $entity,
                $contentVersionSyncToProperties
            );
        }

        return $basics;
    }
}
