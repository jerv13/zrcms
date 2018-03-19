<?php

namespace Zrcms\HttpApiBlockRender\Acl;

use Zrcms\Acl\Api\IsAllowed;
use Zrcms\HttpApi\Acl\HttpApiIsAllowed;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedBlockRender extends HttpApiIsAllowed
{
    const NAME = 'is-allowed-block-render';

    /**
     * @param IsAllowed $isAllowed
     * @param array     $isAllowedOptions
     * @param string    $name
     * @param int       $notAllowedStatus
     * @param bool      $debug
     */
    public function __construct(
        IsAllowed $isAllowed,
        array $isAllowedOptions,
        string $name = self::NAME,
        int $notAllowedStatus = self::DEFAULT_NOT_ALLOWED_STATUS,
        bool $debug = false
    ) {
        parent::__construct(
            $isAllowed,
            $isAllowedOptions,
            $name,
            $notAllowedStatus,
            $debug
        );
    }
}
