<?php

namespace Zrcms\CoreApplication\Api;

use Reliv\CacheRat\Service\Cache;
use Zrcms\Core\Api\GetComponentJs;
use Zrcms\Core\Fields\FieldsComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetComponentJsBasic extends GetComponentFilesContentAbstract implements GetComponentJs
{
    const SCHEME = 'component';
    const DEFAULT_CACHE_KEY = 'GetComponentJsBasic';

    protected $cache;
    protected $cacheKey;

    /**
     * @param Cache  $cache
     * @param string $cacheKey
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function __construct(
        Cache $cache,
        string $cacheKey = self::DEFAULT_CACHE_KEY
    ) {
        parent::__construct(
            FieldsComponent::JAVASCRIPT,
            $cache,
            $cacheKey
        );
    }

    /**
     * @return string
     */
    protected function getScheme(): string
    {
        return static::SCHEME;
    }

    /**
     * @param string $filePathUri
     *
     * @return bool
     */
    protected function isValidScheme(string $filePathUri)
    {
        $scheme = parse_url($filePathUri, PHP_URL_SCHEME);

        // we are the default for empty schemes
        return ($scheme === $this->getScheme() || empty($scheme));
    }
}
