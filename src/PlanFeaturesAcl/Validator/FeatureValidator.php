<?php

namespace PlanFeaturesAcl\Validator;

use PlanFeaturesAcl\Feature\FeatureInterface;

class FeatureValidator implements FeatureValidatorInterface
{

    /**
     * {@inheritDoc}
     */
    public function validate(FeatureInterface $feature, $featureValue, $validatedValue)
    {
        switch ($feature->getType()) {
            case 'bool':
                return true;
                break;
            case 'numeric':
                if (!is_numeric($validatedValue) || !is_numeric($featureValue)) {
                    throw new \InvalidArgumentException();
                }

                return $featureValue > $validatedValue;
                break;
        }
    }
}
