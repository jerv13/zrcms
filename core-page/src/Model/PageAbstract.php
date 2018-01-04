<?php

namespace Zrcms\CorePage\Model;

use Zrcms\Core\Exception\PropertyMissing;
use Zrcms\Core\Model\ContentAbstract;
use Zrcms\CoreContainer\Model\Container;
use Zrcms\CoreContainer\Model\ContainerBasic;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CoreApplication\Api\GetGuidV4;
use Zrcms\CorePage\Api\PreparePageContainerData;
use Zrcms\CorePage\Fields\FieldsPage;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class PageAbstract extends ContentAbstract
{
    /**
     * @param array $properties
     *
     * @throws \Exception
     * @throws \Zrcms\Param\Exception\ParamMissing
     */
    public function __construct(
        array $properties
    ) {
        Param::assertHas(
            $properties,
            FieldsPage::TITLE,
            get_class($this)
        );

        $id = GetGuidV4::invoke();

        $containersData = Param::getArray(
            $properties,
            FieldsPage::CONTAINERS_DATA,
            []
        );

        $properties[FieldsPage::CONTAINERS_DATA] = PreparePageContainerData::invoke(
            $id,
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

        return Param::get(
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

        $containerData = Param::get(
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
