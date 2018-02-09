<?php

namespace Zrcms\Http\Api;

use Reliv\Json\Json;
use Reliv\Json\JsonError;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class QueryParamValueDecodeJson implements QueryParamValueDecode
{
    /**
     * @param string|array $paramValue
     * @param array        $options
     *
     * @return array|mixed
     */
    public function __invoke(
        $paramValue,
        array $options = []
    ) {
        if (is_array($paramValue)) {
            return $this->prepareArray($paramValue);
        }

        return $this->prepare($paramValue);
    }

    /**
     * @param array $paramValue
     *
     * @return array
     */
    protected function prepareArray(array $paramValue)
    {
        $prepared = [];

        foreach ($paramValue as $key => $value) {
            $prepared[$key] = $this->prepare($value);
        }

        return $prepared;
    }

    /**
     * @param $paramValue
     *
     * @return mixed
     */
    protected function prepare($paramValue)
    {
        try {
            $value = Json::decode($paramValue);
        } catch (JsonError $e) {
            $value = $paramValue;
        }

        return $value;
    }
}
