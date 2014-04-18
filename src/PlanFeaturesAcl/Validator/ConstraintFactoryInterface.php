<?php
/**
 * User: alkuk
 * Date: 17.04.14
 * Time: 16:58
 */

namespace PlanFeaturesAcl\Validator;

interface ConstraintFactoryInterface
{
    public function getValidator($type);
}
