<?php

namespace Zrcms\CoreBlock\Api\Component;

use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigJsonFile as CoreReadComponentConfigJsonFile;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigJsonFile extends CoreReadComponentConfigJsonFile implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'block-json';
    const READER_SCHEME = 'block-json';

    protected $prepareComponentConfig;

    /**
     * @param PrepareComponentConfigBlock $prepareComponentConfig
     */
    public function __construct(
        PrepareComponentConfigBlock $prepareComponentConfig
    ) {
        $this->prepareComponentConfig = $prepareComponentConfig;
    }

    /**
     * @param string $componentConfigUri
     * @param array  $options
     *
     * @return array
     * @throws \Exception
     * @throws \Zrcms\Core\Exception\CanNotReadComponentConfig
     */
    public function __invoke(
        string $componentConfigUri,
        array $options = []
    ): array {
        $componentConfig = parent::__invoke($componentConfigUri, $options);

        return $this->prepareComponentConfig->__invoke(
            $componentConfig
        );
    }
}
