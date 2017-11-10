<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Exception\PropertyMissing;
use Zrcms\Content\Model\ContentVersionAbstract;
use Zrcms\ContentCore\Container\Fields\FieldsContainerVersion;
use Zrcms\ContentCore\Container\Model\Container;
use Zrcms\ContentCore\Container\Model\ContainerVersion;
use Zrcms\ContentCore\Container\Model\ContainerVersionBasic;
use Zrcms\ContentCore\Page\Api\AssertValidPath;
use Zrcms\ContentCore\Page\Api\BuildPageContainerVersionId;
use Zrcms\ContentCore\Page\Api\PreparePageContainerData;
use Zrcms\ContentCore\Page\Fields\FieldsPageVersion;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class PageVersionAbstract extends ContentVersionAbstract
{
    /**
     * @param string|null $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        Param::assertNotEmpty(
            $properties,
            FieldsPageVersion::SITE_CMS_RESOURCE_ID
        );

        Param::assertNotEmpty(
            $properties,
            FieldsPageVersion::PATH
        );

        AssertValidPath::invoke(
            Param::getString(
                $properties,
                FieldsPageVersion::PATH
            )
        );

        Param::assertHas(
            $properties,
            FieldsPageVersion::TITLE,
            PropertyMissing::buildThrower(
                FieldsPageVersion::TITLE,
                $properties,
                get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            FieldsPageVersion::KEYWORDS,
            PropertyMissing::buildThrower(
                FieldsPageVersion::KEYWORDS,
                $properties,
                get_class($this)
            )
        );

        $containersData = Param::getArray(
            $properties,
            FieldsPageVersion::CONTAINERS_DATA,
            []
        );

        $properties[FieldsPageVersion::CONTAINERS_DATA] = PreparePageContainerData::invoke(
            $id,
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
        return $this->getProperty(
            FieldsPageVersion::SITE_CMS_RESOURCE_ID
        );
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->getProperty(
            FieldsPageVersion::PATH
        );
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getProperty(
            FieldsPageVersion::TITLE,
            ''
        );
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->getProperty(
            FieldsPageVersion::DESCRIPTION,
            ''
        );
    }

    /**
     * @return string
     */
    public function getKeywords(): string
    {
        return $this->getProperty(
            FieldsPageVersion::KEYWORDS,
            ''
        );
    }

    /**
     * @return array
     */
    public function getContainersData(): array
    {
        return $this->getProperty(
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

        return Param::get(
            $containersData,
            $name,
            null
        );
    }

    /**
     * @return Container[]|ContainerVersion[]
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
     * @return Container|ContainerVersion|null
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

        $id = BuildPageContainerVersionId::invoke(
            $this->getId(),
            $name
        );

        $containerData[FieldsContainerVersion::SITE_CMS_RESOURCE_ID] = $this->getSiteCmsResourceId();
        $containerData[FieldsContainerVersion::PATH] = $name;

        return new ContainerVersionBasic(
            $id,
            $containerData,
            $this->getCreatedByUserId(),
            $this->getCreatedReason()
        );
    }
}
