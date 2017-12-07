<?php

namespace Zrcms\CoreApplication\Api;

/**
 * @deprecated Only a place holder
 *
 * @author     James Jervis - https://github.com/jerv13
 */
class ApiNoop
{
    /**
     * @param string $serviceName
     *
     * @throws \Exception
     */
    public function __construct(
        string $serviceName = 'UNKNOWN'
    ) {
        throw new \Exception(
            "Api service {$serviceName} must have concrete implementation and the service must be over-ridden"
        );
    }
}
