<?php

namespace spec\PlanFeaturesAcl\Validator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PlanFeaturesAcl\Feature\AttachedInterface;
use PlanFeaturesAcl\Feature\FeatureInterface;

class FeatureValidatorSpec extends ObjectBehavior
{
    function let(
        FeatureInterface $boolFeature,
        FeatureInterface $numericFeature
    ) {

        $boolFeature->getType()->willReturn('bool');
        $boolFeature->getValidationRules()->willReturn(null);

        $numericFeature->getType()->willReturn('numeric');
        $numericFeature->getValidationRules()->willReturn(json_encode(
            array(
                'lt'
            )
        ));

    }

    function it_is_initializable()
    {
        $this->shouldHaveType('PlanFeaturesAcl\Validator\FeatureValidatorInterface');
    }

    function it_should_always_valid_bool_feature(FeatureInterface $boolFeature)
    {
        $this->validate($boolFeature, null, null)->shouldReturn(true);
    }

    function it_should_throw_invalid_argument_exception_if_argument_not_numeric(
        FeatureInterface $numericFeature
    ) {
        $this->shouldThrow('\InvalidArgumentException')
            ->duringValidate($numericFeature, '10', 'some text');
    }

    function it_should_throw_invalid_value_exception_if_argument_not_numeric(
        FeatureInterface $numericFeature
    ) {
        $this->shouldThrow('\InvalidArgumentException')
            ->duringValidate($numericFeature, 'some text', '1');
    }

    function it_should_valid_numeric_feature_with_lower_than_constraint(
        FeatureInterface $numericFeature
    ) {
        $this->validate($numericFeature, '10', '9')->shouldReturn(true);
        $this->validate($numericFeature, '10', 9)->shouldReturn(true);
        $this->validate($numericFeature, '10', '3')->shouldReturn(true);
        $this->validate($numericFeature, '10', '0')->shouldReturn(true);
        $this->validate($numericFeature, '10', 0)->shouldReturn(true);

        $this->validate($numericFeature, '10', 10)->shouldReturn(false);
        $this->validate($numericFeature, '10', '10')->shouldReturn(false);
        $this->validate($numericFeature, '10', '12')->shouldReturn(false);
    }

}
