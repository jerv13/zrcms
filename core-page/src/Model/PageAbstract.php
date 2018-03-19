<?php

namespace Zrcms\CorePage\Model;

use Zrcms\Core\Exception\PropertyMissing;
use Zrcms\Core\Model\ContentAbstract;
use Zrcms\CoreContainer\Fields\FieldsContainer;
use Zrcms\CoreContainer\Fields\FieldsContainerVersion;
use Zrcms\CoreContainer\Model\Container;
use Zrcms\CoreContainer\Model\ContainerBasic;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CoreApplication\Api\GetGuidV4;
use Zrcms\CorePage\Api\PreparePageContainerData;
use Zrcms\CorePage\Fields\FieldsPage;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class PageAbstract extends ContentAbstract
{
    /**
     * @param array $properties
     *
     * @throws \Exception
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyMissing
     */
    public function __construct(
        array $properties
    ) {
        Property::assertHas(
            $properties,
            FieldsPage::TITLE,
            get_class($this)
        );

        $id = GetGuidV4::invoke();

        $containersData = Property::getArray(
            $properties,
            FieldsPage::CONTAINERS_DATA,
            []
        );

        $properties[FieldsPage::CONTAINERS_DATA] = PreparePageContainerData::invoke(
            $id,
            'UNKNOWN_SITE_CMS_RESOURCE_ID',
            $containersData
        );

        parent::__construct(
            $properties,
            $id
        );
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->findProperty(
            FieldsPage::TITLE,
            ''
        );
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->findProperty(
            FieldsPage::DESCRIPTION,
            ''
        );
    }

    /**
     * @return string
     */
    public function getKeywords(): string
    {
        return $this->findProperty(
            FieldsPage::KEYWORDS,
            ''
        );
    }

    /**
     * @return array
     */
    public function getContainersData(): array
    {
        return $this->findProperty(
            FieldsPage::CONTAINERS_DATA,
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

        return Property::get(
            $containersData,
            $name,
            null
        );
    }

    /**
     * @return Container[]
     */
    public function getContainers(): array
    {
        $containers = [];
        $containersData = $this->getContainersData();

        foreach ($containersData as $containerName => $containerData) {
            $containers[$containerName] = $this->findContainer($containerName);
        }

        return $containers;
    }

    /**
     * @param string $name
     *
     * @return Container|null
     */
    public function findContainer(string $name = Page::DEFAULT_CONTAINER_NAME)
    {
        $containersData = $this->getContainersData();

        $containerData = Property::get(
            $containersData,
            $name,
            null
        );

        if (empty($containerData)) {
            return null;
        }

        return new ContainerBasic(
            $containerData
        );
    }
}
