<?php

namespace Zrcms\Core\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ActionCmsResource
{
    const PUBLISH_RESOURCE_SAME_VERSION = 'publish-sameVersion';
    const UNPUBLISH_RESOURCE_SAME_VERSION = 'unpublish-sameVersion';

    const PUBLISH_RESOURCE_NEW_VERSION = 'publish-newVersion';
    const UNPUBLISH_RESOURCE_NEW_VERSION = 'unpublish-newVersion';

    protected static $actionMap
        = [
            '0:0' => self::UNPUBLISH_RESOURCE_SAME_VERSION,
            '0:1' => self::UNPUBLISH_RESOURCE_NEW_VERSION,
            '1:0' => self::PUBLISH_RESOURCE_SAME_VERSION,
            '1:1' => self::PUBLISH_RESOURCE_NEW_VERSION
        ];

    /**
     * @param bool $published
     * @param bool $versionChanged
     *
     * @return mixed
     */
    public static function invoke(
        bool $published,
        bool $versionChanged
    ):string {
        $key = (int)$published . ':' . (int)$versionChanged;

        return self::$actionMap[$key];
    }
}
