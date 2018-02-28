<?php

namespace Zrcms\CoreView\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ViewStrategyResultBasic implements ViewStrategyResult
{
    protected $strategy;
    protected $status;

    /**
     * @param string|null $strategy
     * @param int         $status
     */
    public function __construct(
        $strategy,
        int $status = self::OK_STATUS
    ) {
        $this->strategy = $strategy;
        $this->status = $status;
    }

    /**
     * @return string|null
     */
    public function getStrategy()
    {
        return $this->strategy;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return bool
     */
    public function isOk(): bool
    {
        return (!empty($this->strategy) && $this->status === self::OK_STATUS);
    }
}
