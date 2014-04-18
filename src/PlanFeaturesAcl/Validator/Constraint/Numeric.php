<?php

namespace PlanFeaturesAcl\Validator\Constraint;

class Numeric
{



    /**
     * {@inheritDoc}
     */
    public function getAvailableRules()
    {
        return array(
            'lt', //equal
            'lte', //less than or equal
            'gt', //greater than
            'gte', //greater than or equal
            'eq', //equal
            'neq' //not equal
        );
    }
}
