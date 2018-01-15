<?php

namespace Zrcms\InputValidation\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidationResultBasic implements ValidationResult
{
    protected $valid;
    protected $code;
    protected $details;

    /**
     * @param bool   $valid
     * @param string $code
     * @param array  $details
     */
    public function __construct(
        bool $valid = true,
        string $code = '',
        array $details = []
    ) {
        $this->valid = $valid;
        $this->code = $code;
        $this->details = $details;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return array
     */
    public function getDetails(): array
    {
        return $this->details;
    }

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function findDetail(string $key, $default = null)
    {
        if (array_key_exists($key, $this->details)) {
            return $this->details[$key];
        }

        return $default;
    }
}
