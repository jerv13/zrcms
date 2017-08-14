<?php

namespace Zrcms\HttpExpressive1\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetStatusSitePropertyPagePathConfig implements GetStatusSitePropertyPagePath
{
    /**
     * @var array
     */
    protected $statusPropertyMap= [];

    /**
     * @param array $statusPropertyMap
     */
    public function __construct(
        array $statusPropertyMap = []
    ) {
        $this->addStatuses($statusPropertyMap);
    }

    /**
     * @param array $statusPropertyMap
     *
     * @return void
     */
    protected function addStatuses(
        array $statusPropertyMap
    ) {
        $statusPropertyMapPrepared = [];
        foreach ($statusPropertyMap as $status => $siteProperty) {
            $statusPropertyMapPrepared[(string)$status] = (string)$siteProperty;
        }
        $this->statusPropertyMap = array_merge(
            $this->statusPropertyMap,
            $statusPropertyMapPrepared
        );
    }

    /**
     * @param int|string $status
     * @param null       $default
     *
     * @return mixed|null
     */
    public function __invoke($status, $default = null)
    {
        $status = (string)$status;
        if (array_key_exists($status, $this->statusPropertyMap)) {
            return $this->statusPropertyMap[$status];
        }

        return $default;
    }
}
