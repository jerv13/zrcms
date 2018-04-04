<?php

namespace Zrcms\CoreApplication\Api;

use Psr\Http\Message\ServerRequestInterface;
use Reliv\CacheRat\Service\Cache;
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
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function __construct(
        string $componentFilesProperty,
        Cache $cache,
        string $cacheKey
    ) {
        $this->componentFilesProperty = $componentFilesProperty;
        $this->cache = $cache;
        $this->cacheKey = $cacheKey;
        $this->cache->set($this->cacheKey, []);
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
        $content = '';

        /** @var Component $component */
        foreach ($components as $component) {
            $filePathUris = $component->findProperty(
                $this->componentFilesProperty
            );

            if (empty($filePathUris)) {
                continue;
            }

            $content = $this->getContent(
                $component->getModuleDirectory(),
                $filePathUris,
                $content
            );
        }

        return $content;
    }

    /**
     * @return string
     */
    abstract protected function getScheme(): string;

    /**
     * @param string $moduleDirectory
     * @param array  $filePathUris
     * @param string $content
     *
     * @return string
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function getContent(
        string $moduleDirectory,
        array $filePathUris,
        $content = ''
    ) {
        foreach ($filePathUris as $sourceName => $filePathUri) {
            if (!$this->isValidScheme($filePathUri)) {
                continue;
            }

            if ($this->hasCache($filePathUri)) {
                $content .= $this->getCache($filePathUri);
                continue;
            }

            $fileContent = $this->readFileContents(
                $moduleDirectory,
                $filePathUri
            );

            $this->setCache($filePathUri, $fileContent);

            $content .= $fileContent;
        }

        return $content;
    }

    /**
     * @param string $moduleDirectory
     * @param string $filePathUri
     *
     * @return string
     * @throws \Exception
     */
    protected function readFileContents(
        string $moduleDirectory,
        string $filePathUri
    ) {
        $realFilePath = GetModuleDirectoryFilePathBasic::invoke(
            $moduleDirectory,
            $filePathUri,
            get_class($this)
        );

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
     * @param string $filePathUri
     *
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function hasCache(string $filePathUri)
    {
        $cache = $this->cache->get($this->cacheKey);

        return array_key_exists($filePathUri, $cache);
    }

    /**
     * @param string $filePathUri
     *
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function getCache(string $filePathUri)
    {
        if (!$this->hasCache($filePathUri)) {
            return null;
        }
        $cache = $this->cache->get($this->cacheKey);

        return $cache[$filePathUri];
    }

    /**
     * @param string $filePathUri
     * @param string $fileContent
     *
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function setCache(
        string $filePathUri,
        string $fileContent
    ) {
        $cache = $this->cache->get($this->cacheKey);

        $cache[$filePathUri] = $fileContent;

        $this->cache->set($this->cacheKey, $cache);
    }
}
