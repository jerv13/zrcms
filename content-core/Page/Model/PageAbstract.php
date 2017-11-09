<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Exception\PropertyMissing;
use Zrcms\Content\Model\ContentAbstract;
use Zrcms\ContentCore\Container\Model\Container;
use Zrcms\ContentCore\Container\Model\ContainerBasic;
use Zrcms\ContentCore\Container\Model\ContainerVersionBasic;
use Zrcms\ContentCore\GetGuidV4;
use Zrcms\ContentCore\Page\Api\PreparePageContainerData;
use Zrcms\ContentCore\Page\Fields\FieldsPage;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class PageAbstract extends ContentAbstract
{
    /**
     * @param array $properties
     */
    public function __construct(
        array $properties
    ) {
        Param::assertHas(
            $properties,
            FieldsPage::TITLE,
            PropertyMissing::buildThrower(
                FieldsPage::TITLE,
                $properties,
                get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            FieldsPage::KEYWORDS,
            PropertyMissing::buildThrower(
                FieldsPage::KEYWORDS,
                $properties,
                get_class($this)
            )
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
        return $this->getProperty(
            FieldsPage::TITLE,
            ''
        );
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->getProperty(
            FieldsPage::DESCRIPTION,
            ''
        );
    }

    /**
     * @return string
     */
    public function getKeywords(): string
    {
        return $this->getProperty(
            FieldsPage::KEYWORDS,
            ''
        );
    }

    /**
     * @return array
     */
    public function getContainersData(): array
    {
        return $this->getProperty(
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
