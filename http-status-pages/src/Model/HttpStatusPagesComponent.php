<?php

namespace Zrcms\HttpStatusPages\Model;

use Zrcms\Content\Model\Component;
use Zrcms\Content\Model\ComponentAbstract;
use Zrcms\HttpStatusPages\Fields\FieldsHttpStatusPagesComponent;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpStatusPagesComponent extends ComponentAbstract implements Component
{
    const NAME = 'zrcms-http-status-pages';

    /**
     * @param string      $type
     * @param string      $name
     * @param string      $configLocation
     * @param string      $moduleDirectory
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     */
    public function __construct(
        string $type,
        string $name,
        string $configLocation,
        string $moduleDirectory,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        $statusPropertyMap = Param::getArray(
            $properties,
            FieldsHttpStatusPagesComponent::STATUS_TO_SITE_PATH_PROPERTY,
            []
        );

        $statusPropertyMap = $this->prepareStatusPropertyMap($statusPropertyMap);
        $this->assertValidStatusPages($statusPropertyMap);

        $properties[FieldsHttpStatusPagesComponent::STATUS_TO_SITE_PATH_PROPERTY] = $statusPropertyMap;

        parent::__construct(
            $type,
            $name,
            $configLocation,
            $moduleDirectory,
            $properties,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }

    /**
     * @param array $statusPropertyMap
     *
     * @return array
     */
    protected function prepareStatusPropertyMap(
        array $statusPropertyMap
    ) {
        $statusPropertyMapPrepared = [];
        foreach ($statusPropertyMap as $status => $siteProperty) {
            $statusPropertyMapPrepared[(string)$status] = (array)$siteProperty;
        }

        return $statusPropertyMapPrepared;
    }

    /**
     * @param $status
     *
     * @return bool
     */
    public function hasStatusPage($status): bool
    {
        $statusPages = Param::getArray(
            $this->properties,
            FieldsHttpStatusPagesComponent::STATUS_TO_SITE_PATH_PROPERTY,
            []
        );

        $status = (string)$status;

        return array_key_exists($status, $statusPages);
    }

    /**
     * @param int|string $status
     * @param null       $default
     *
     * @return mixed|null
     */
    public function findStatusPage($status, $default = null)
    {
        $statusPages = $this->getStatusPages();

        $status = (string)$status;
        $statusPage = Param::getArray(
            $statusPages,
            $status,
            $default
        );

        return $statusPage;
    }

    /**
     * @return array
     */
    public function getStatusPages(): array
    {
        $statusPages = Param::getArray(
            $this->properties,
            FieldsHttpStatusPagesComponent::STATUS_TO_SITE_PATH_PROPERTY,
            []
        );

        return $statusPages;
    }

    /**
     * @param string|int $status
     * @param null       $default
     *
     * @return string|null
     */
    public function findStatusPagePath($status, $default = null)
    {
        $statusPage = $this->findStatusPage($status, null);

        if (empty($statusPage)) {
            return $default;
        }

        return (string)$statusPage['path'];
    }

    /**
     * @param string|int $status
     * @param string     $default
     *
     * @return string|null
     */
    public function findStatusPageType($status, $default = 'render')
    {
        $statusPage = $this->findStatusPage($status, null);

        if (empty($statusPage)) {
            return $default;
        }

        return (string)$statusPage['type'];
    }

    /**
     * @param array $statusPages
     *
     * @return void
     * @throws \Exception
     */
    protected function assertValidStatusPages(array $statusPages)
    {
        foreach ($statusPages as $statusPage) {
            if (!is_array($statusPage)) {
                throw new \Exception('statusPage must be array: ' . json_encode($statusPage));
            }

            if (!array_key_exists('path', $statusPage)) {
                throw new \Exception('path is required for a status page: ' . json_encode($statusPage));
            }

            if (!array_key_exists('type', $statusPage)) {
                throw new \Exception('type is required for a status page: ' . json_encode($statusPage));
            }
        }
    }
}
