<?php

namespace Zrcms\CoreApplication\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Cache\Service\Cache;
use Zrcms\Core\Fields\FieldsComponent;
use Zrcms\Core\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class GetComponentFilesContentAbstract
{
    protected $componentFilesProperty;
    protected $cache;
    protected $cacheKey;

    /**
     * @param string $componentFilesProperty
     * @param Cache  $cache
     * @param string $cacheKey
     */
    public function __construct(
        string $componentFilesProperty,
        Cache $cache,
        string $cacheKey
    ) {
        $this->componentFilesProperty = $componentFilesProperty;
        $this->cache = $cache;
        $this->cacheKey = $cacheKey;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $components
     * @param array                  $options
     *
     * @return string
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $components,
        array $options = []
    ): string {
        if ($this->hasCache()) {
            return $this->getCache();
        }

        $content = '';

        /** @var Component $component */
        foreach ($components as $component) {
            $filePathUris = $component->findProperty(
                $this->componentFilesProperty
            );

            if (empty($filePathUris)) {
                continue;
            }

            $content = $this->getContent($filePathUris, $content);
        }

        $this->setCache($content);

        return $content;
    }

    /**
     * @return string
     */
    abstract protected function getScheme(): string;

    /**
     * @param array  $filePathUris
     * @param string $content
     *
     * @return string
     * @throws \Exception
     */
    protected function getContent(array $filePathUris, $content = '')
    {
        foreach ($filePathUris as $sourceName => $filePathUri) {
            if (!$this->isValidScheme($filePathUri)) {
                continue;
            }

            $content .= $this->readFileContents($filePathUri);
        }

        return $content;
    }

    /**
     * @param string $filePathUri
     *
     * @return bool|string
     * @throws \Exception
     */
    protected function readFileContents(string $filePathUri)
    {
        $filePath = parse_url($filePathUri, PHP_URL_PATH);

        $realFilePath = realpath($filePath);

        if (empty($realFilePath)) {
            throw new \Exception(
                'Path is not valid: ' . $filePathUri
                . ' in: ' . get_class($this)
            );
        }

        if (!is_file($realFilePath)) {
            throw new \Exception(
                'File path must be a file: ' . $filePathUri
                . ' in: ' . get_class($this)
            );
        }

        return file_get_contents($realFilePath);
    }

    /**
     * @param string $filePathUri
     *
     * @return bool
     */
    protected function isValidScheme(string $filePathUri)
    {
        $scheme = parse_url($filePathUri, PHP_URL_SCHEME);

        return ($scheme === $this->getScheme());
    }

    /**
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function hasCache()
    {
        return ($this->cache->has($this->cacheKey));
    }

    /**
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function getCache()
    {
        return $this->cache->get($this->cacheKey);
    }

    /**
     * @param $configs
     *
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function setCache($configs)
    {
        $this->cache->set($this->cacheKey, $configs);
    }
}
