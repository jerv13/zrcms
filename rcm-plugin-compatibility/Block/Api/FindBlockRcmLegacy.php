<?php

namespace Zrcms\RcmPluginCompatibility\Block\Api;

use Zrcms\Core\Block\Api\FindBlock;
use Zrcms\RcmPluginCompatibility\Block\Internal\ConfigRepository;

class FindBlockRcmLegacy implements FindBlock
{
    protected $configRepo;

    public function __construct(ConfigRepository $configRepo)
    {
        $this->configRepo = $configRepo;
    }

    /**
     * @param string $name
     * @param array $options
     *
     * @return Block|null
     */
    public function __invoke(
        $name,
        array $options = []
    ) {
        return $this->configRepo->findById($name);
    }
}
