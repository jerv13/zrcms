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
    protected $getBlockConfigFields;
    protected $getBlockConfigFieldsBcSubstitution;
    protected $prepareComponentConfigBlockFieldsToDefaultConfig;

    /**
     * @param GetBlockConfigFields                             $getBlockConfigFields
     * @param GetBlockConfigFieldsBcSubstitution               $getBlockConfigFieldsBcSubstitution
     * @param PrepareComponentConfigBlockFieldsToDefaultConfig $prepareComponentConfigBlockFieldsToDefaultConfig
     */
    public function __construct(
        GetBlockConfigFields $getBlockConfigFields,
        GetBlockConfigFieldsBcSubstitution $getBlockConfigFieldsBcSubstitution,
        PrepareComponentConfigBlockFieldsToDefaultConfig $prepareComponentConfigBlockFieldsToDefaultConfig
    ) {
        $this->getBlockConfigFields = $getBlockConfigFields;
        $this->getBlockConfigFieldsBcSubstitution = $getBlockConfigFieldsBcSubstitution;
        $this->prepareComponentConfigBlockFieldsToDefaultConfig = $prepareComponentConfigBlockFieldsToDefaultConfig;
    }

    /**
     * @param array $blockConfig
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        array $blockConfig,
        array $options = []
    ): array {
        // @todo Split this out an use composite for PrepareComponentConfigBlock
        $blockConfig = $this->prepareComponentConfigBlockFieldsToDefaultConfig->__invoke(
            $blockConfig,
            $options
        );
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

        if (!isset($blockConfigBc[FieldsBlockComponentConfig::FIELDS])) {
            $blockConfigBc[FieldsBlockComponentConfig::FIELDS] = [];
        }

        if (empty($blockConfigBc[FieldsBlockComponentConfig::DEFAULT_CONFIG])) {
            $blockConfigBc[FieldsBlockComponentConfig::DEFAULT_CONFIG]
                = $blockConfigBc[FieldsBlockComponentConfig::FIELDS];
        }

        // @todo Not used, remove it?
        //$blockConfigBc[FieldsBlockComponentConfig::COMPONENT_CLASS] = BlockComponentBasic::class;
        //$blockConfigBc[FieldsBlockComponentConfig::TYPE] = 'block';

        return $blockConfigBc;
    }
}
