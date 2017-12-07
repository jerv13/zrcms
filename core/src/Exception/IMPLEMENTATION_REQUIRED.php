<?php

namespace Zrcms\Core\Exception;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IMPLEMENTATION_REQUIRED extends \Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     *
     * @throws IMPLEMENTATION_REQUIRED
     */
    public function __construct(
        $message = '',
        $code = 0,
        \Exception $previous = null
    ) {
        parent::__construct(
            "Api service must have concrete implementation and the service config must be over-ridden: {$message}",
            $code,
            $previous
        );

        throw $this;
    }
}
