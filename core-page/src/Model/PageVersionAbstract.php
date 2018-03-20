<?php

namespace Zrcms\CorePage\Model;

use Reliv\ArrayProperties\Property;
use Zrcms\Core\Model\ContentVersionAbstract;
use Zrcms\CoreContainer\Fields\FieldsContainerVersion;
use Zrcms\CoreContainer\Model\Container;
use Zrcms\CoreContainer\Model\ContainerVersion;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CorePage\Api\AssertValidPath;
use Zrcms\CorePage\Api\BuildPageContainerVersionId;
use Zrcms\CorePage\Api\PreparePageContainerData;
use Zrcms\CorePage\Fields\FieldsPageVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class PageVersionAbstract extends ContentVersionAbstract
{
    /**
     * @param string      $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     *
     * @throws \Exception
     * @throws \Throwable
     * @throws \Zrcms\CorePage\Exception\InvalidPath
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyException
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        Property::assertNotEmpty(
            $properties,
            FieldsPageVersion::SITE_CMS_RESOURCE_ID
        );

        Property::assertNotEmpty(
            $properties,
            FieldsPageVersion::PATH
        );

        AssertValidPath::invoke(
            Property::getString(
                $properties,
                FieldsPageVersion::PATH
            )
        );

        Property::assertHas(
            $properties,
            FieldsPageVersion::TITLE,
            get_class($this)
        );

        $containersData = Property::getArray(
            $properties,
            FieldsPageVersion::CONTAINERS_DATA,
            []
        );

        $properties[FieldsPageVersion::CONTAINERS_DATA] = PreparePageContainerData::invoke(
            $id,
            $properties[FieldsPageVersion::SITE_CMS_RESOURCE_ID],
            $containersData
        );

        parent::__construct(
            $id,
            $properties,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }

    /**
     * @return string
     */
    public function getSiteCmsResourceId(): string
    {
        return $this->findProperty(
            FieldsPageVersion::SITE_CMS_RESOURCE_ID
        );
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->findProperty(
            FieldsPageVersion::PATH,
            ''
        );
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->findProperty(
            FieldsPageVersion::TITLE,
            ''
        );
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->findProperty(
            FieldsPageVersion::DESCRIPTION,
            ''
        );
    }

    /**
     * @return string
     */
    public function getKeywords(): string
    {
        return $this->findProperty(
            FieldsPageVersion::KEYWORDS,
            ''
        );
    }

    /**
     * @return array
     */
    public function getContainersData(): array
    {
        return $this->findProperty(
            FieldsPageVersion::CONTAINERS_DATA,
            []
        );
    }

    /**
     * @param string $name
     *
     * @return array|null
     */
    public function findContainerData(string $name = Page::DEFAULT_CONTAINER_NAME)
    {
        $containersData = $this->getContainersData();

        foreach ($containersData as $containerData) {
            if ($containerData[FieldsContainerVersion::NAME] === $name) {
                return $containerData;
            }
        }

        return null;
    }

    /**
     * @return ContainerVersion[]
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    public function getContainers(): array
    {
        $containers = [];
        $containersData = $this->getContainersData();

        foreach ($containersData as $containerName => $containerData) {
            $containers[] = $this->findContainer($containerName);
        }

        return $containers;
    }

    /**
     * @param string $name
     *
     * @return null|ContainerVersionBasic
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    public function findContainer(string $name = Page::DEFAULT_CONTAINER_NAME)
    {
        $containerData = $this->findContainerData($name);

        if (empty($containerData)) {
            return null;
        }

        $id = BuildPageContainerVersionId::invoke(
            $this->getId(),
            $name
        );

        $containerData[FieldsContainerVersion::SITE_CMS_RESOURCE_ID] = $this->getSiteCmsResourceId();
        $containerData[FieldsContainerVersion::NAME] = $name;

        return new ContainerVersionBasic(
            $id,
            $containerData,
            $this->getCreatedByUserId(),
            $this->getCreatedReason()
        );
    }
}
