<?php

namespace Zrcms\HttpExpressive1\Model;

use Zrcms\Content\Model\Component;
use Zrcms\ContentCore\Basic\Model\BasicComponentAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpExpressiveComponent extends BasicComponentAbstract implements Component
{
    const NAME = 'zrcms-http-expressive-1';

    /**
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {

        $statusPropertyMap = Param::getArray(
            $properties,
            PropertiesHttpExpressiveComponent::STATUS_TO_SITE_PATH_PROPERTY,
            []
        );

        $statusPropertyMap = $this->prepareStatusPropertyMap($statusPropertyMap);

        $properties[PropertiesHttpExpressiveComponent::STATUS_TO_SITE_PATH_PROPERTY] = $statusPropertyMap;

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
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
            $statusPropertyMapPrepared[(string)$status] = (string)$siteProperty;
        }

        return $statusPropertyMapPrepared;
    }

    /**
     * @param int|string $status
     * @param null       $default
     *
     * @return mixed|null
     */
    public function getSitePagePathProperty($status, $default = null)
    {
        $statusPropertyMap = Param::getArray(
            $this->properties,
            PropertiesHttpExpressiveComponent::STATUS_TO_SITE_PATH_PROPERTY,
            []
        );

        $status = (string)$status;
        if (array_key_exists($status, $statusPropertyMap)) {
            return $statusPropertyMap[$status];
        }

        return $default;
    }
}
