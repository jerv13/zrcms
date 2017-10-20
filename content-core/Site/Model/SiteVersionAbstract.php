<?php

namespace Zrcms\ContentCore\Site\Model;

use Zrcms\Content\Exception\PropertyMissing;
use Zrcms\Content\Model\ContentVersionAbstract;
use Zrcms\ContentCore\Site\Fields\FieldsSiteVersion;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class SiteVersionAbstract extends ContentVersionAbstract
{
    /**
     * @param string|null $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        Param::assertHas(
            $properties,
            FieldsSiteVersion::THEME_NAME,
            PropertyMissing::buildThrower(
                FieldsSiteVersion::THEME_NAME,
                $properties,
                get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            FieldsSiteVersion::LOCALE,
            PropertyMissing::buildThrower(
                FieldsSiteVersion::LOCALE,
                $properties,
                get_class($this)
            )
        );

        $statusPages = Param::getArray(
            $properties,
            FieldsSiteVersion::STATUS_PAGES,
            []
        );

        $this->assertValidStatusPages($statusPages);

        parent::__construct(
            $id,
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getThemeName(): string
    {
        return $this->getProperty(
            FieldsSiteVersion::THEME_NAME,
            ''
        );
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->getProperty(
            FieldsSiteVersion::LOCALE,
            'en_US'
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
        $statusPages = $this->getProperty(
            FieldsSiteVersion::STATUS_PAGES,
            []
        );

        return Param::getArray(
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
