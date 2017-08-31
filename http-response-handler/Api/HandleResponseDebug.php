<?php

namespace Zrcms\HttpResponseHandler\Api;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\HttpResponseHandler\Exception\CanNotHandleResponse;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HandleResponseDebug implements HandleResponse
{
    /**
     * @var bool
     */
    protected $debug;

    /**
     * @param bool $debug
     */
    public function __construct(
        $debug = false
    ) {
        $this->debug = $debug;
    }

    /**
     * @param ResponseInterface $response
     * @param array             $options
     *
     * @return ResponseInterface|HtmlResponse
     * @throws CanNotHandleResponse
     */
    public function __invoke(
        ResponseInterface $response,
        array $options = []
    ) {
        $message = Param::get(
            $options,
            HandleResponseOptions::MESSAGE,
            ''
        );

        $this->assertCanHandleResponse($message);

        $stream = $response->getBody();
        $stream->rewind();
        $contents = $stream->getContents();

        $contents = "<pre>{$message}</pre>\n\n{$contents}";

        return new HtmlResponse(
            $contents,
            $response->getStatusCode(),
            $response->getHeaders()
        );
    }

    /**
     * @param string|null $message
     *
     * @return void
     * @throws CanNotHandleResponse
     */
    public function assertCanHandleResponse(
        $message
    ) {
        if ($this->debug && !empty($message)) {
            return;
        }

        throw new CanNotHandleResponse();
    }
}
