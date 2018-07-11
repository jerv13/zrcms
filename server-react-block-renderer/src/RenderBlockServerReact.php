<?php

namespace Zrcms\ServerReactBlockRenderer;

use Zrcms\Core\Model\Content;
use Zrcms\CoreBlock\Api\Render\RenderBlock;
use Zrcms\ServerReactBlockRenderer\Exception\InvalidResponseFromRemoteRenderServiceException;

/**
 * @TODO    implement caching?
 *
 * Class RenderBlockServerReact
 * @package Zrcms\ServerReactBlockRenderer
 */
class RenderBlockServerReact implements RenderBlock
{
    protected $remoteRenderApiUrl;
    protected $ignoreSSLErrors;

    public function __construct(string $remoteRenderApiUrl, $ignoreSSLErrors = false)
    {
        $this->remoteRenderApiUrl = $remoteRenderApiUrl;
        $this->ignoreSSLErrors = $ignoreSSLErrors;
    }

    /**
     * @param Content $block
     * @param array   $renderTags
     * @param array   $options
     *
     * @return string
     * @throws InvalidResponseFromRemoteRenderServiceException
     */
    public function __invoke(
        Content $block,
        array $renderTags,
        array $options = []
    ): string {
        $response = self::httpPost(
            $this->remoteRenderApiUrl,
            [
                'name' => $block->findProperty('blockComponentName'),
                'props' => $renderTags //Contains id, config, data, configJson properties
            ],
            $this->ignoreSSLErrors
        );

        if (!is_array($response) || !array_key_exists('html', $response)) {
            throw new InvalidResponseFromRemoteRenderServiceException(
                'Invalid response from remote render service: ' . json_encode($response)
            );
        };

        return $response['html'];
    }

    /**
     * Do an HTTP post request
     *
     * Note: This doesn't use a client library such as Guzzle in order to avoid
     * dependency version mismatch conflicts
     *
     * @param      $url
     * @param      $postData
     * @param bool $ignoreSSLErrors
     *
     * @return mixed
     */
    protected static function httpPost($url, $postData, $ignoreSSLErrors = false)
    {
        $options = array(
            'http' => array(
                'method' => 'POST',
                'content' => json_encode($postData),
                'header' => 'Content-Type: application/json\r\n' .
                    'Accept: application/json\r\n'
            )
        );

        if ($ignoreSSLErrors) {
            $options['ssl'] = [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ];
        }

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return json_decode($result, true);
    }
}
