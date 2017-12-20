<?php

namespace Zrcms\Cache\Service;

/**
 * @todo   Implement valid key checks and TTL
 * @todo   Throw exceptions per PSR docs
 * @author James Jervis - https://github.com/jerv13
 */
class CacheFilePhp implements Cache
{
    const VALUE = 'value';
    const TTL = 'ttl';
    const CREATE_TIME = 'createTime';

    protected $cacheFilePath;
    protected $values = [];

    public function __construct(
        string $cacheFilePath
    ) {
        $this->cacheFilePath = $cacheFilePath;
    }

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $values = $this->readFileContents();

        if ($this->has($key)) {
            return $values[$key][self::VALUE];
        }

        return $default;
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @param null   $ttl
     *
     * @return bool
     */
    public function set($key, $value, $ttl = null)
    {
        $values = $this->readFileContents();

        $values[$key] = [];

        $values[$key][self::VALUE] = $value;
        $values[$key][self::TTL] = $ttl;
        $values[$key][self::CREATE_TIME] = time();

        return $this->writeFileContents($values);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function delete($key)
    {
        if ($this->has($key)) {
            $values = $this->readFileContents();
            unset($values[$key]);

            return $this->writeFileContents($values);
        }

        return false;
    }

    /**
     * @return bool
     */
    public function clear()
    {
        $values = [];

        return $this->writeFileContents($values);
    }

    /**
     * @param array $keys
     * @param null  $default
     *
     * @return array
     */
    public function getMultiple($keys, $default = null)
    {
        $values = [];
        foreach ($keys as $key) {
            $values[$key] = $this->get($key, $default);
        }

        return $values;
    }

    /**
     * @param array $values
     * @param null  $ttl
     *
     * @return bool
     */
    public function setMultiple($values, $ttl = null)
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }

        return true;
    }

    /**
     * @param array $keys
     *
     * @return bool
     */
    public function deleteMultiple($keys)
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }

        return true;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        $values = $this->readFileContents();

        return array_key_exists($key, $values);
    }

    /**
     * @return array
     */
    protected function readFileContents(): array
    {
        if (!file_exists($this->cacheFilePath)) {
            return [];
        }

        return include($this->cacheFilePath);
    }

    /**
     * @param $values
     *
     * @return bool
     */
    protected function writeFileContents($values): bool
    {
        if (!file_exists($this->cacheFilePath)) {
            $this->createDirectory($this->cacheFilePath);
        }

        $result = file_put_contents(
            $this->cacheFilePath,
            $this->buildFileContents($values)
        );

        return ($result !== false);
    }

    /**
     * @param $values
     *
     * @return string
     */
    protected function buildFileContents($values): string
    {
        return '' .
            "<?php\n"
            . ' return '
            . var_export($values, true) . ";\n"
            . '';
    }

    /**
     * @param $filePath
     *
     * @return void
     */
    protected function createDirectory($filePath)
    {
        $parts = explode('/', $filePath);
        $file = array_pop($parts);
        $dir = '';
        foreach ($parts as $part) {
            if (!is_dir($dir .= "/$part")) {
                mkdir($dir);
            }
        }
    }
}
