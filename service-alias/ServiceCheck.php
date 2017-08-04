<?php

namespace Zrcms\ServiceAlias;

use Zrcms\ServiceAlias\Exception\ServiceSelfReferenceException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ServiceCheck
{
    /**
     * @param object $service
     * @param object $subService
     *
     * @return void
     * @throws ServiceSelfReferenceException
     */
    public static function assertNotSelfReference(
        $service,
        $subService
    ) {
        if (get_class($service) == get_class($subService)) {
            throw new ServiceSelfReferenceException(
                'Class ' . get_class($service) . ' can not use itself as a service.'
            );
        }
    }
}
