<?php

namespace Zrcms\ContentCore\Block\Api;

use Zrcms\ContentCore\Block\Model\BlockComponentConfigFields;

/**
 * @deprecated BC only
 * @author James Jervis - https://github.com/jerv13
 */
class PrepareBlockConfigBc implements PrepareBlockConfig
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
    public function __invoke(array $blockConfig): array
    {
        $blockConfigFields = $this->getBlockConfigFields->__invoke();
        $blockConfigFieldsBcSubstitution = $this->getBlockConfigFieldsBcSubstitution->__invoke();

        $blockConfigBc = [];

        foreach ($blockConfig as $key => $value) {
            if (array_key_exists($key, $blockConfigFieldsBcSubstitution)) {
                $blockConfigBc[$blockConfigFieldsBcSubstitution[$key]] = $value;
            }
            // Keeping the old values for BC
            $blockConfigBc[$key] = $value;
        }

        // Set defaults
        foreach ($blockConfigFields as $key => $value) {
            if (!array_key_exists($key, $blockConfigBc)) {
                $blockConfigBc[$key] = $value;
            }
        }

        if (empty($blockConfigBc[BlockComponentConfigFields::DEFAULT_CONFIG])) {
            $blockConfigBc[BlockComponentConfigFields::DEFAULT_CONFIG]
                = $blockConfigBc[BlockComponentConfigFields::FIELDS];
        }

        return $blockConfigBc;
    }

    /**
     * @deprecated
     * @param array $blockConfig
     *
     * @return array
     */
    public function old(array $blockConfig): array
    {
        $blockConfigFields = $this->getBlockConfigFields->__invoke();
        $blockConfigFieldsBcSubstitution = $this->getBlockConfigFieldsBcSubstitution->__invoke();

        $blockConfigBc = [];

        foreach ($blockConfig as $key => $value) {
            if (array_key_exists($key, $blockConfigFieldsBcSubstitution)) {
                $blockConfigBc[$blockConfigFieldsBcSubstitution[$key]] = $value;
            }
        }

        $new = array_merge($blockConfigFields, $blockConfig);

        $new = array_merge($blockConfigBc, $new);

        if (empty($new[BlockComponentConfigFields::DEFAULT_CONFIG])) {
            $new[BlockComponentConfigFields::DEFAULT_CONFIG] = $new[BlockComponentConfigFields::FIELDS];
        }

        $t = $this->t($blockConfig);
        var_dump(
            'o', $blockConfig,
            'n',$new,
            't',$t
        );

        return $new;
    }

}
