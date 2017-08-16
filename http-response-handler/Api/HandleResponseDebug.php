<?php

namespace Zrcms\HttpResponseHandler\Api;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HandleResponseDebug implements HandleResponse
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     * @param array                  $options
     *
     * @return mixed
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null,
        array $options = []
    ) {
        $message = Param::get(
            $options,
            HandleResponseOptions::MESSAGE,
            ''
        );

        if (!empty($message)) {

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

        return $response;
    }
}
