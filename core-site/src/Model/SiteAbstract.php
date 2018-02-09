<?php

namespace Zrcms\CoreSite\Model;

use Zrcms\Core\Exception\PropertyMissing;
use Zrcms\Core\Model\ContentAbstract;
use Zrcms\CoreSite\Fields\FieldsSite;
use Reliv\Json\Json;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class SiteAbstract extends ContentAbstract
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
            FieldsSite::THEME_NAME,
            get_class($this)
        );

        Property::assertHas(
            $properties,
            FieldsSite::LOCALE,
            get_class($this)
        );

        $statusPages = Property::getArray(
            $properties,
            FieldsSite::STATUS_PAGES,
            []
        );

        $this->assertValidStatusPages($statusPages);

        parent::__construct(
            $properties
        );
    }

    /**
     * @return string
     */
    public function getThemeName(): string
    {
        return $this->findProperty(
            FieldsSite::THEME_NAME,
            ''
        );
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->findProperty(
            FieldsSite::LOCALE,
            ''
        );
    }

    /**
     * @param string     $httpStatus
     * @param mixed|null $default
     *
     * @return string|null
     */
    public function findStatusPage(string $httpStatus, $default = null)
    {
        $statusPages = $this->findProperty(
            FieldsSite::STATUS_PAGES,
            []
        );

        return Property::getArray(
            $statusPages,
            $httpStatus,
            $default
        );
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
                throw new \Exception('statusPage must be array: ' . Json::encode($statusPage));
            }

            if (!array_key_exists('path', $statusPage)) {
                throw new \Exception('path is required for a status page: ' . Json::encode($statusPage));
            }

            if (!array_key_exists('type', $statusPage)) {
                throw new \Exception('type is required for a status page: ' . Json::encode($statusPage));
            }
        }
    }
}
