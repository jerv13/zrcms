<?php

namespace Zrcms\Http\Response;

use Zend\Diactoros\Response;
use Zend\Diactoros\Response\InjectContentTypeTrait;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Stream;
use Zrcms\Json\Json;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ZrcmsJsonResponse extends Response
{
    use InjectContentTypeTrait;

    /**
     * Default flags for json_encode; value of:
     *
     * <code>
     * JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES
     * </code>
     *
     * @const int
     */
    const DEFAULT_JSON_FLAGS = 79;

    /**
     * @var mixed
     */
    private $payload;

    /**
     * @var mixed
     */
    protected $apiMessages = null;

    /**
     * @var int
     */
    private $encodingOptions;

    /**
     * Create a JSON response with the given data.
     *
     * Default JSON encoding is performed with the following options, which
     * produces RFC4627-compliant JSON, capable of embedding into HTML.
     *
     * - JSON_HEX_TAG
     * - JSON_HEX_APOS
     * - JSON_HEX_AMP
     * - JSON_HEX_QUOT
     * - JSON_UNESCAPED_SLASHES
     *
     * @param mixed $data            Data to convert to JSON.
     * @param mixed $apiMessages     Messages to convert to JSON.
     * @param int   $status          Integer status code for the response; 200 by default.
     * @param array $headers         Array of headers to use at initialization.
     * @param int   $encodingOptions JSON encoding options to use.
     *
     * @throws \InvalidArgumentException if unable to encode the $data to JSON.
     */
    public function __construct(
        $data,
        $apiMessages = null,
        $status = 200,
        array $headers = [],
        $encodingOptions = self::DEFAULT_JSON_FLAGS
    ) {
        $this->setPayload($data);
        $this->setApiMessages($apiMessages);

        $this->encodingOptions = $encodingOptions;

        $apiResult = $this->getApiResult();

        $json = $this->jsonEncode($apiResult, $this->encodingOptions);
        $body = $this->createBodyFromJson($json);

        $headers = $this->injectContentType('application/json', $headers);

        parent::__construct($body, $status, $headers);
    }

    /**
     * @return mixed
     */
    public function getApiMessages()
    {
        return $this->apiMessages;
    }

    /**
     * @param $apiMessages
     *
     * @return JsonResponse|ZrcmsJsonResponse
     */
    public function withApiMessages($apiMessages)
    {
        $new = clone $this;
        $new->setApiMessages($apiMessages);

        return $this->updateBodyFor($new);
    }

    /**
     * @param $apiMessages
     */
    private function setApiMessages($apiMessages)
    {
        $this->apiMessages = $apiMessages;
    }

    /**
     * @return array
     */
    public function getApiResult()
    {
        $apiMessages = $this->apiMessages;

        if (empty($apiMessages)) {
            $apiMessages = [];
        }

        return [
            'data' => $this->payload,
            'messages' => $apiMessages,
        ];
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param $data
     *
     * @return ZrcmsJsonResponse
     */
    public function withPayload($data)
    {
        $new = clone $this;
        $new->setPayload($data);

        return $this->updateBodyFor($new);
    }

    /**
     * @return int
     */
    public function getEncodingOptions()
    {
        return $this->encodingOptions;
    }

    /**
     * @param $encodingOptions
     *
     * @return ZrcmsJsonResponse
     */
    public function withEncodingOptions($encodingOptions)
    {
        $new = clone $this;
        $new->encodingOptions = $encodingOptions;

        return $this->updateBodyFor($new);
    }

    /**
     * @param string $json
     *
     * @return Stream
     */
    private function createBodyFromJson($json)
    {
        $body = new Stream('php://temp', 'wb+');
        $body->write($json);
        $body->rewind();

        return $body;
    }

    /**
     * Encode the provided data to JSON.
     *
     * @param mixed $data
     * @param int   $encodingOptions
     *
     * @return string
     * @throws \InvalidArgumentException if unable to encode the $data to JSON.
     */
    private function jsonEncode($data, $encodingOptions)
    {
        if (is_resource($data)) {
            throw new \InvalidArgumentException('Cannot JSON encode resources');
        }

        $json = Json::encode(
            $data,
            $encodingOptions,
            512,
            'From: ' . __CLASS__
        );

        return $json;
    }

    /**
     * @param $data
     */
    private function setPayload($data)
    {
        if (is_object($data)) {
            $data = clone $data;
        }

        $this->payload = $data;
    }

    /**
     * Update the response body for the given instance.
     *
     * @param ZrcmsJsonResponse $toUpdate
     *
     * @return static
     */
    private function updateBodyFor(self $toUpdate)
    {
        $apiResult = $toUpdate->getApiResult();
        $json = $this->jsonEncode($apiResult, $toUpdate->encodingOptions);
        $body = $this->createBodyFromJson($json);

        return $toUpdate->withBody($body);
    }
}
