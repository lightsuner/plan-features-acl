<?php

namespace PlanFeaturesAcl;

use PlanFeaturesAcl\Plan\PlanInterface;
use PlanFeaturesAcl\Feature\AttachedInterface;
use PlanFeaturesAcl\Validator\FeatureValidatorInterface;
use DomainException;

class Provider implements ProviderInterface
{
    /**
     * @var bool
     */
    protected $enabled = false;

    /**
     * @var \PlanFeaturesAcl\Plan\PlanInterface
     */
    protected $plan;

    /**
     * @var \PlanFeaturesAcl\Feature\AttachedInterface[]
     */
    protected $attachedFeatures;

    /**
     * @var \PlanFeaturesAcl\Validator\FeatureValidatorInterface
     */
    protected $validator;



    public function __construct(FeatureValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * {@inheritDoc}
     */
    public function isGranted($featureName, $validatedValue = null)
    {
        if (!$this->isEnable()) {
            return true;
        }

        if (!$this->plan instanceof PlanInterface) {
            return false;
        }

        if (!array_key_exists($featureName, $this->attachedFeatures)) {
            return false;
        }

        $attachedFeature = $this->attachedFeatures[$featureName];

        return $this->validator
            ->validate($attachedFeature->getFeature(), $attachedFeature->getValue(), $validatedValue);
    }

    /**
     * {@inheritDoc}
     */
    public function setPlan(PlanInterface $plan = null)
    {

        $this->clear();

        $this->plan = $plan;

        $this->updateFeatures();

    }

    /**
     * {@inheritDoc}
     */
    public function disable()
    {
        $this->enabled = false;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function isEnable()
    {
        return $this->enabled;
    }

    /**
     * {@inheritDoc}
     */
    public function enable()
    {
        $this->enabled = true;

        return $this;
    }

    /**
     * Fetch attached features from plan
     *
     * @return $this
     */
    protected function updateFeatures()
    {
        if ($this->plan instanceof PlanInterface) {
            foreach ($this->plan->getAttachedFeatures() as $attachedFeature) {
                $this->attachedFeatures[$attachedFeature->getFeature()->getSlug()] = $attachedFeature;
            }
        }

        return $this;
    }

    /**
     * Clear provider data
     *
     * @return $this
     */
    protected function clear()
    {
        $this->plan = null;
        $this->attachedFeatures = array();

        return $this;
    }
}
