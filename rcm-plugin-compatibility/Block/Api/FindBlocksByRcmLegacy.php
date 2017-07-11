<?php

namespace Zrcms\RcmPluginCompatibility\Block\Api;

use Zrcms\Core\Block\Api\FindBlock;
use Zrcms\RcmPluginCompatibility\Block\Internal\ConfigRepository;

class FindBlocksByRcmLegacy implements FindBlock
{
    protected $configRepo;

    public function __construct(ConfigRepository $configRepo)
    {
        $this->configRepo = $configRepo;
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null|int $limit
     * @param null|int $offset
     * @param array $options
     *
     * @return array
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array {
        return $this->configRepo->find($criteria, $orderBy, $limit, $offset);
    }
}
