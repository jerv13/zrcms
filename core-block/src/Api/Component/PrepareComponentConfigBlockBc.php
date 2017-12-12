<?php

namespace Zrcms\CoreBlock\Api\Component;

use Zrcms\CoreBlock\Api\GetBlockConfigFields;
use Zrcms\CoreBlock\Api\GetBlockConfigFieldsBcSubstitution;
use Zrcms\CoreBlock\Fields\FieldsBlockComponentConfig;
use Zrcms\CoreBlock\Model\BlockComponentBasic;

/**
 * @deprecated BC ONLY
 * @author     James Jervis - https://github.com/jerv13
 */
class PrepareComponentConfigBlockBc implements PrepareComponentConfigBlock
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
     * @param array $options
     *
     * @return array
     */
    public function __invoke(
        array $blockConfig,
        array $options = []
    ): array {
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

        // Since type

        // Set defaults
        foreach ($blockConfigFields as $key => $value) {
            if (!array_key_exists($key, $blockConfigBc)) {
                $blockConfigBc[$key] = $value;
            }
        }

        if (empty($blockConfigBc[FieldsBlockComponentConfig::DEFAULT_CONFIG])) {
            $blockConfigBc[FieldsBlockComponentConfig::DEFAULT_CONFIG]
                = $blockConfigBc[FieldsBlockComponentConfig::FIELDS];
        }

        $componentConfig[FieldsBlockComponentConfig::COMPONENT_CLASS] = BlockComponentBasic::class;
        $componentConfig[FieldsBlockComponentConfig::TYPE] = 'block';

        return $blockConfigBc;
    }
}
