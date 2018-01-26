<?php

namespace Zrcms\ServiceAlias\Api;

use Zrcms\ServiceAlias\Exception\ServiceSelfReferenceException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class AssertNotSelfReference
{
    /**
     * @param object $service
     * @param object $subService
     *
     * @return void
     * @throws ServiceSelfReferenceException
     */
    public static function invoke(
        $service,
        $subService
    ) {
        if (get_class($service) == get_class($subService)) {
            throw new ServiceSelfReferenceException(
                'Class ' . get_class($service) . ' can not use itself as a service.'
            );
        }
    }

    /**
     * @param object $service
     * @param object $subService
     *
     * @return void
     * @throws ServiceSelfReferenceException
     */
    public function __invoke(
        $service,
        $subService
    ) {
        self::invoke(
            $service,
            $subService
        );
    }
}
