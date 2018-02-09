<?php

namespace Zrcms\CoreSite\Model;

use Zrcms\Core\Exception\PropertyMissing;
use Zrcms\Core\Model\ContentVersionAbstract;
use Zrcms\CoreSite\Fields\FieldsSiteVersion;
use Reliv\Json\Json;
use Zrcms\Locale\Api\DefaultLocal;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class SiteVersionAbstract extends ContentVersionAbstract
{
    /**
     * @param string $id
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     * @param null   $createdDate
     *
     * @throws \Exception
     * @throws \Throwable
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyException
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyMissing
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
            FieldsSiteVersion::HOST
        );

        Property::assertHas(
            $properties,
            FieldsSiteVersion::THEME_NAME,
            get_class($this)
        );

        Property::assertHas(
            $properties,
            FieldsSiteVersion::LOCALE,
            get_class($this)
        );

        $statusPages = Property::getArray(
            $properties,
            FieldsSiteVersion::STATUS_PAGES,
            []
        );

        $this->assertValidStatusPages($statusPages);

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
    public function getHost(): string
    {
        return $this->findProperty(
            FieldsSiteVersion::HOST,
            ''
        );
    }

    /**
     * @return string
     */
    public function getThemeName(): string
    {
        return (string)$this->findProperty(
            FieldsSiteVersion::THEME_NAME,
            ''
        );
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return (string)$this->findProperty(
            FieldsSiteVersion::LOCALE,
            DefaultLocal::get()
        );
    }

    /**
     * @param string     $httpStatus
     * @param mixed|null $default
     *
     * @return array
     */
    public function findStatusPage(string $httpStatus, $default = null)
    {
        $statusPages = $this->findProperty(
            FieldsSiteVersion::STATUS_PAGES,
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
