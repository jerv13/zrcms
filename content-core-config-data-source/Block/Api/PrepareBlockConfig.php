<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api;

use Zrcms\ContentCoreConfigDataSource\Block\Model\BlockConfigFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PrepareBlockConfig
{
    /**
     * @var GetBlockConfigFields
     */
    protected $getBlockConfigFields;

    /**
     * @var GetBlockConfigFieldsBcSubstitution
     */
    protected $getBlockConfigFieldsBcSubstitution;

    /**
     * @param GetBlockConfigFields               $getBlockConfigFields
     * @param GetBlockConfigFieldsBcSubstitution $getBlockConfigFieldsBcSubstitution
     */
    public function __construct(
        GetBlockConfigFields $getBlockConfigFields,
        GetBlockConfigFieldsBcSubstitution $getBlockConfigFieldsBcSubstitution
    ) {
        $this->getBlockConfigFields = $getBlockConfigFields;
        $this->getBlockConfigFieldsBcSubstitution = $getBlockConfigFieldsBcSubstitution;
    }

    /**
     * @param array $blockConfig
     *
     * @return array
     */
    public function __invoke(array $blockConfig)
    {
        $blockConfigFields = $this->getBlockConfigFields->__invoke();
        $blockConfigFieldsBcSubstitution = $this->getBlockConfigFields->__invoke();

        $blockConfigBc = [];

        foreach ($blockConfig as $key => $value) {
            if (array_key_exists($key, $blockConfigFieldsBcSubstitution)) {
                $blockConfigBc[$blockConfigFieldsBcSubstitution[$key]] = $value;
            }
        }

        $new = array_merge($blockConfigFields, $blockConfig);

        $new = array_merge($blockConfigBc, $new);

        if (empty($new[BlockConfigFields::DEFAULT_CONFIG])) {
            $new[BlockConfigFields::DEFAULT_CONFIG] = $new[BlockConfigFields::FIELDS];
        }

        return $new;
    }
}
